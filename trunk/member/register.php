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
session_start();
define('CURSCRIPT', 'register');
require("../libraries/common.inc.php");
require(PHPB2B_ROOT."libraries/sendmail.inc.php");
require(CACHE_PATH. 'cache_membergroup.php');
require(API_PATH.'passport.class.php');
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
$member_reg_check = $_PB_CACHE['setting']['regcheck'];
$member_reg_auth = $_PB_CACHE['setting']['new_userauth'];
if (isset($_GET['action'])) {
	$do = trim($_GET['action']);
	if ($do == "done") {
		$reg_tips = null;
		$reg_result = true;
		$is_company = false;
		if ($member_reg_check) {
			switch ($register_type) {
				case 1:
					$reg_tips = L("pls_active_your_account");
					$reg_result = false;
					break;
				case 2:
					$reg_tips = L("pls_wait_for_check");
					$reg_result = false;
				default:
					break;
			}
		}else{
			$member_info = $pdb->GetRow("SELECT membergroup_id,membertype_id FROM {$tb_prefix}members WHERE id=".$_SESSION['MemberID']);
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
	if($member_reg_check=="1" || $member_reg_auth!=0){
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
		$hash = urlencode(authcode($tmp_username."|".$exp_time, "ENCODE"));
		$str = "Please active it through : <a href='".URL."pending.php?hash=".$hash."'>".URL."pending.php?hash=".$hash."</a>";
		$sended = pb_sendmail($member->params['data']['member']['email'], $tmp_username, 'Please active your account', $str);
	}
	if($updated){
		$key = $member->table_name."_id";
		$last_member_id = $member->$key;
		$gopage = URL.'member/register.php?action=done';
		pheader("location:".$gopage);
	}else{
		setvar("member", $_POST['data']['member']);
		setvar("memberfield", $_POST['data']['memberfield']);
		setvar("ErrorMsg", $member->getError());
	}
}
if(isset($_PB_CACHE['companytype']))
$company_types = $_PB_CACHE['companytype'];
formhash();
setvar("CompanyTypes",$company_types);
setvar("sid",md5(uniqid($time_stamp)));
render($tpl_file);
?>