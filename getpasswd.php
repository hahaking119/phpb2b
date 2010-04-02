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
 * @version $Id: getpasswd.php 416 2009-12-26 13:31:08Z steven $
 */
define('CURSCRIPT', 'getpasswd');
require("libraries/common.inc.php");
require("share.inc.php");
require("libraries/sendmail.inc.php");
uses("member");
$member = new Members();
if (isset($_POST['do'])) {
	pb_submit_check("data");
	$do = trim($_POST['do']);
	if ($do == "reset") {
		$username = trim($_POST['data']['username']);
		$userpass = trim($_POST['data']['password1']);
		if (!empty($userpass) && !empty($username)) {
			$user_exists = $member->checkUserExist($username, true);
			if (!$user_exists) {
				flash("member_not_exists");
			}else{
				$result = $pdb->Execute("UPDATE {$tb_prefix}members SET userpass='".$member->authPasswd($userpass)."' WHERE id=".$member->info['id']." AND status='1'");
				if ($result) {
					flash("reset_and_login", "logging.php");
				}
			}
		}
	}
}
if (isset($_POST['action'])) {
	pb_submit_check("data");
	$checked = true;
	$login_name = trim($_POST['data']['username']);
	$user_email = trim($_POST['data']['email']);
	if(!pb_check_email($user_email)){
		setvar("ERRORS", L("wrong_email_format"));
		$checked = false;
	}else{
		$member->setInfoByUserName($login_name);
		$member_info = $member->getInfo();
		if(!$member_info || empty($member_info)){
			setvar("ERRORS", L('member_not_exists'));
			setvar("postLoginName", $login_name);
			setvar("postUserEmail", $user_email);
			$checked = false;
		}elseif (!pb_strcomp($user_email, $member_info['email'])){
			setvar("ERRORS", L("please_input_email"));
			$checked = false;
		}
		if(!pb_check_email($member_info['email'])){
			$checked = false;
		}
		if ($checked) {
			$exp_time = $time_stamp + 86400;
			$hash = authcode(addslashes($member_info['username'])."\t".$exp_time,"ENCODE");
			setvar("hash", rawurlencode($hash));
			setvar("expire_date", date("Y-m-d",strtotime("+1 day")));
			$body = $smarty->fetch('default/emails/getpasswd'.$smarty->tpl_ext);
			$sended = pb_sendmail($member_info['email'], $login_name, L("pls_reset_passwd"), $body);
			if(!$sended)
			{
				flash("email_send_false");
			}else{
				flash("getpasswd_email_sended");
			}
		}
	}
}
formhash();
render("getpasswd");
?>