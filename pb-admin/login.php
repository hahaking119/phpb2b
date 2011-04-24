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
 * @version $Id: login.php 504 2009-12-28 05:01:52Z steven $
 */
require("../libraries/common.inc.php");
if (session_id() == '' ) { 
	require_once(LIB_PATH. "session_php.class.php");
	$session = new PbSessions();
}
uses("adminfield","setting", "member");
$adminer = new Adminfields();
$member = new Members();
$setting = new Settings();
if (isset($_GET['action'])) {
	if ($_GET['action']=="dereg") {
		usetcookie("admin", "");
		unset($_SESSION['last_adminer_time']);
	}
}
capt_check("capt_login_admin");
if (isset($_POST['do'])) {
	$do = trim($_POST['do']);
	if ($do == "login") {
		pb_submit_check('data');
	    if (!empty($_POST['data']['username']) && (!empty($_POST['data']['userpass']))) {
	    	$checked = false;
	    	$uname = $_POST['data']['username'];
	    	$upass = $_POST['data']['userpass'];
	    	$checked = $adminer->checkUserLogin($uname,$upass);
	    	if($checked > 0){
	    		pheader("Location:index.php");
	    	}else{
	    		setvar("LoginError","<h3 class='error'>".$adminer->error."</h3>");
	    	}
	    }
	}
}
formhash();
$smarty->template_dir = "template/";
$smarty->setCompileDir("pb-admin".DS);
template("login");
exit;
?>