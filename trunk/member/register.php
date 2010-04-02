<?php
/**
 * NOTE   :  PHP versions 4 and 5
 *
 * PHPB2B :  An Opensource Business To Business E-Commerce Script (http://www.phpb2b.com/)
 * Copyright 2007-2009, Ualink E-Commerce Co,. Ltd.
 *
 * Licensed under The GPL License (http://www.opensource.org/licenses/gpl-license.php)
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * @copyright Copyright 2007-2009, Ualink E-Commerce Co,. Ltd. (http://phpb2b.com)
 * @since PHPB2B v 1.0.0
 * @link http://phpb2b.com
 * @package phpb2b
 * @version $Id: register.php 463 2009-12-27 03:25:16Z steven $
 */
define('CURSCRIPT', 'register');
require("../libraries/common.inc.php");
require("../share.inc.php");
if (session_id() == '' ) { 
	require_once(LIB_PATH. "session_php.class.php");
	$session = new PbSessions();
}
require(PHPB2B_ROOT."libraries/sendmail.inc.php");
require(CACHE_PATH. 'cache_membergroup.php');
require(CACHE_PATH. 'cache_setting1.php');
require(API_PATH.'passport.class.php');
require(PHPB2B_ROOT. "languages/".$app_lang."/emails.inc.php");
$passport = new Passports();
uses("member","company","companyfield", "memberfield","membergroup");
$cfg['reg_time_seperate'] = 3*60;
$memberfield = new Memberfields();
$member = new Members();
$membergroup = new Membergroups();
$company = new Companies();
$companyfield = new Companyfields();
$check_invite_code = false;
$register_type = $_PB_CACHE['setting']['register_type'];
$ip_reg_sep = $_PB_CACHE['setting']['ip_reg_sep'];
$forbid_ip = $_PB_CACHE['setting']['forbid_ip'];
$conditions = array();
capt_check("capt_register");
$tpl_file = "member.register";
$member_reg_auth = $_PB_CACHE['setting']['new_userauth'];
if (isset($_GET['action'])) {
	$do = trim($_GET['action']);
	if ($do == "done") {
		$reg_tips = null;
		$reg_result = true;
		$is_company = false;
		if ($member_reg_auth) {
			switch ($member_reg_auth) {
				case 1:
					$reg_tips = L("pls_active_your_account");
					$reg_result = false;
					break;
				default:
					$reg_tips = L("pls_wait_for_check");
					$reg_result = false;
					break;
			}
		}else{
			$member_info = $pdb->GetRow("SELECT membergroup_id,membertype_id FROM {$tb_prefix}members WHERE id='".$pb_user['pb_userid']."'");
			$gid = $member_info['membergroup_id'];
			$smarty->assign("groupname", $_PB_CACHE['membergroup'][$gid]['name']);
			$smarty->assign("groupimg", "images/group/".$_PB_CACHE['membergroup'][$gid]['avatar']);
			if ($member_info['membertype_id'] == 2) {
				$is_company = true;
			}
		}
		$smarty->assign("is_company", $is_company);
		$smarty->assign("result", $reg_result);
		$smarty->assign("RegTips", $reg_tips);
		render("member.register.done");
		exit;
	}
}
if (!empty($ip_reg_sep)) {
	$cfg['reg_time_seperate'] = $ip_reg_sep*60*60;
}
if ($register_type=="close_register") {
	flash("register_closed", URL);
}elseif ($register_type=="open_invite_reg"){
	setvar("IfInviteCode", true);
	$check_invite_code = true;
}
if(isset($_POST['register'])){
	$is_company = false;
	$if_need_check = false;
	$register_type = trim($_POST['register']);
	switch ($register_type) {
		case "personal":
			$default_membergroupid = $pdb->GetOne("SELECT default_membergroup_id FROM {$tb_prefix}membertypes WHERE id=1");
			break;
		case "company":
			$default_membergroupid = $pdb->GetOne("SELECT default_membergroup_id FROM {$tb_prefix}membertypes WHERE id=2");
			$is_company = true;
			break;
		default:
			$default_membergroupid = $membergroup->field("id","is_default=1");
			break;
	}
	$member->setParams();
	$memberfield->setParams();
	$member->params['data']['member']['membergroup_id'] = $default_membergroupid;
	$time_limits = $pdb->GetOne("SELECT default_live_time FROM {$tb_prefix}membergroups WHERE id={$default_membergroupid}");
	$member->params['data']['member']['service_start_date'] = $time_stamp;
	$member->params['data']['member']['service_end_date'] = $membergroup->getServiceEndtime($time_limits);
	$member->params['data']['member']['membertype_id'] = ($is_company)?2:1;
	if($member_reg_auth=="1" || $member_reg_auth!=0 || !empty($_PB_CACHE['setting']['new_userauth'])){
		$member->params['data']['member']['status'] = 0;
		$if_need_check = true;
	}else{
		$member->params['data']['member']['status'] = 1;
	}
	$updated = false;
	$updated = $member->Add();
	if ($member_reg_auth == 1) {
		$if_need_check = true;
		$exp_time = $time_stamp+86400;
		$tmp_username = $member->params['data']['member']['username'];
		$hash = rawurlencode(authcode("{$tmp_username}\t".$exp_time, "ENCODE"));
		$str = str_replace(array("%hash%"), $hash, L("pls_pending_account", "tpl"));
		$sended = pb_sendmail($member->params['data']['member']['email'], $tmp_username, L("pls_active_your_account", "tpl"), $str);
	}
	if (!empty($_PB_CACHE['setting1']['welcome_msg'])) {
		$sended = pb_sendmail($member->params['data']['member']['email'], $tmp_username, 
		str_replace(
		array("%username%", "%sitename%"), 
		array($tmp_username, 
		$_PB_CACHE['setting']['site_name']), 
		$_PB_CACHE['setting1']['welcome_msg_title']), 
		str_replace(
		array("%username%", "%sitename%", "%serviceemail%"), 
		array($tmp_username, 
		$_PB_CACHE['setting']['site_name'], 
		$_PB_CACHE['setting']['service_email']), 
		$_PB_CACHE['setting1']['welcome_msg_content']));
	}
	if($updated){
		$key = $member->table_name."_id";
		$last_member_id = $member->$key;
		$gopage = URL.'member/register.php?action=done';
		pheader("location:".$gopage);
	}else{
		setvar("member", $_POST['data']['member']);
		if(isset($_POST['data']['memberfield'])) setvar("memberfield", $_POST['data']['memberfield']);
		setvar("ErrorMsg", $member->getError());
	}
}
if(isset($_PB_CACHE['companytype'])){
$company_types = $_PB_CACHE['companytype'];
setvar("CompanyTypes",$company_types);
}
formhash();
setvar("sid",md5(uniqid($time_stamp)));
setvar("tmpname",pb_radom(6));
render($tpl_file);
?>