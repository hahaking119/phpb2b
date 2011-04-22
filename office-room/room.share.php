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
 * @version $Id: room.share.php 458 2009-12-27 03:05:45Z steven $
 */
if ( session_id() == '' ) { 
	session_start();
}
$office_theme_name = "";
require(PHPB2B_ROOT.'languages'.DS.$app_lang.DS.'template.room.inc.php');
require(CACHE_PATH. "cache_membergroup.php");
uses("member", "memberfield");
$member = new Members();
$memberfield = new Memberfields();
$smarty->template_dir = "template/";
$smarty->setCompileDir("office-room".DS);
$smarty->flash_layout = "flash";
$check_invite_code = false;
if (isset($_PB_CACHE['setting']['register_type'])) {
	$register_type = $_PB_CACHE['setting']['register_type'];
	if ($register_type=="open_invite_reg"){
	    setvar("IfInviteCode", true);
	}
}
if (empty($_SESSION['MemberID']) || empty($_SESSION['MemberName'])) {
	uclearcookies();
	pheader("location:".URL."logging.php?forward=".urlencode(pb_get_host().$php_self));
}
$memberinfo = $member->getInfoById($_SESSION['MemberID']);
$g = $_PB_CACHE['membergroup'][$memberinfo['membergroup_id']];
unset($_PB_CACHE['membergroup']);
if (!empty($g['auth_level'])) {
	$auth = sprintf("%04b", $g['auth_level']);
	$menu['basic'] = $auth[0];
	$menu['offer'] = $auth[1];
	$menu['product'] = $auth[2];
	$menu['company'] = $auth[3];
	setvar("menu", $menu);
}
if ($memberinfo['membertype_id']==2) {
	$companyinfo = $pdb->GetRow("SELECT c.* FROM {$tb_prefix}companies c LEFT JOIN {$tb_prefix}companyfields cf ON c.id=cf.company_id WHERE c.member_id=".$memberinfo['id']);
	if (!empty($companyinfo)) {
		$company_id = $companyinfo['id'];
		setvar("COMPANYINFO", $companyinfo);
	}
}
function check_permission($perm)
{
	global $g, $smarty;
	$allow = ($perm=="space")? "allow_space" : $perm."_allow";
	if (!$g[$allow]) {
		$message = L("have_no_perm", "msg", L($allow, "tpl"));
		$smarty->assign('action_img', "failed.png");
		$smarty->assign('url', 'javascript:;');
		$smarty->assign('message', $message);
		$smarty->assign('page_title', strip_tags($message));
		template($smarty->flash_layout);
		exit();
	}
}
$new_pm = $pdb->GetOne("SELECT count(id) AS amount FROM {$tb_prefix}messages WHERE status='0' AND  to_member_id=".$_SESSION['MemberID']);
setvar("newpm", (empty($new_pm) || !$new_pm)? false : $new_pm);
formhash();
?>