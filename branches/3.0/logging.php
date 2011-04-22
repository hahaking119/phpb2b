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
 * @version $Id: logging.php 416 2009-12-26 13:31:08Z steven $
 */
session_start();
define('CURSCRIPT', 'logging');
require("libraries/common.inc.php");
uses("member","company","point");
require(PHPB2B_ROOT. 'libraries/sendmail.inc.php');
require(API_PATH.'passport.class.php');
$passport = new Passports();
$company = new Companies();
$point = new Points();
$member = new Members();
$referer = "";
capt_check("capt_logging");
if(isset($_POST['action']) && ($_POST['action']=="logging")){
	if(!empty($_POST['data']['login_name']) && !empty($_POST['data']['login_pass'])){
		unset($_SESSION['authnum_session']);
		$tmpUserName = $_POST['data']['login_name'];
		$tmpUserPass = $_POST['data']['login_pass'];
		$checked = $member->checkUserLogin($tmpUserName,$tmpUserPass);
		$tmp_memberinfo = array();
		if ($checked > 0) {
			$tmp_memberinfo = $member->info;
			$point->update("logging", $member->info['id']);
			if (!empty($_REQUEST['forward'])) {
				pheader("location:".$_REQUEST['forward']);
			}
			switch ($tmp_memberinfo['office_redirect']) {
				case 1:
					$goto_page = URL;
					break;
				case 2:
					$goto_page = "office-room/";
					break;
				case 3:
					$goto_page = "office-room/offer.php";
					break;
				case 4:
					$goto_page = "office-room/pms.php";
					break;
				default:
					$goto_page = URL;
					break;
			}
			pheader('location: '.$goto_page);
		}elseif ($checked == (-2) ) {
			$errmsg = L('member_not_exists');
		}elseif ($checked == (-3)) {
			$errmsg = L('login_pwd_false');
		}elseif ($checked == (-4)) {
			$errmsg = L('member_checking');
		}else {
			$errmsg = L('login_faild');
		}
		setvar("LoginError",$errmsg);
	}
}

function ua_referer($default = '') {
	global $referer;
	$indexname = URL;
	$default = empty($default) ? $indexname : '';
	$referer = pb_htmlspecialchar($referer);
	if(!preg_match("/(\.php|[a-z]+(\-\d+)+\.html)/", $referer) || strpos($referer, 'logging.php')) {
		$referer = $default;
	}
	return $referer;
}
if(isset($_GET['action']) && ($_GET['action'] == "logout")){
	$referer = null;
	$referer = ua_referer();
	session_destroy();
	uclearcookies();
	if (isset($_GET['fr'])) {
		if ($_GET['fr']=="cp") {
			usetcookie("admin", '');
		}
	}
	$gopage = $referer;
	if (!empty($_GET['forward'])) {
		pheader("location:".$_GET['forward']);
	}else{
		pheader("location:".$gopage);
		exit;
	}
}
formhash();
render("logging");
?>