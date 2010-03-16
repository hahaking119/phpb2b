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
 * @version $Id: ajax.php 481 2009-12-28 01:05:06Z steven $
 */
define('CURSCRIPT', 'ajax');
define('NOROBOT', TRUE);
require_once 'libraries/common.inc.php';
require("share.inc.php");
require_once 'libraries/json_config.php';
$return = array();
$result = array();
$post_actions = array("checkpasswd");
$get_actions = array("checkusername");
uses("member", "company");
$member = new Members();
$company = new Companies();
if (isset($_GET['action'])) {
	$action = trim($_GET['action']);
	switch ($action) {
		case "checkusername":
			if(isset($_GET['username'])) {
				$result = call_user_func_array($action, array($_GET['username']));		
				if($result == true){
					$return['isError'] = 1;
				}else{
					$return['isError'] = 0;
				}
			}
			ajax_exit($return);
			break;
		case "addtag":
			break;
		case "checkemail":
			if(isset($_GET['email'])) {
				$result = call_user_func_array($action, array($_GET['email']));		
				if($result == true){
					$return['isError'] = 1;
				}else{
					$return['isError'] = 0;
				}
			}
			ajax_exit($return);
			break;
		default:
			break;
	}
}

if (isset($_POST['action'])) {
	$action = trim($_POST['action']);
	switch ($action) {
		case "checkpasswd":
			if(isset($_POST['oldpass'])) {
				$result = call_user_func_array($action, array($_POST['oldpass'], $pb_userinfo['pb_userid']));		
				if($result){
					$return['isError'] = 0;
					$return['oldpass'] = $_POST['oldpass'];
				}else{
					$return['isError'] = 1;
				}
			}
			ajax_exit($return);
			break;
		default:
			break;
	}
}

function checkpasswd($input_passwd, $member_id)
{
	global $member;
	return $member->checkUserPasswdById($input_passwd, $member_id);
}

function checkusername($input_username)
{
	global $member;
	return $member->checkUserExist($input_username, false);
}

function checkemail($email)
{
	global $member;
	return $member->checkUserExistsByEmail($email);
}

function checkcompanyname($company_name)
{
	global $company;
	return $company->checkNameExists($company_name);
}
?>