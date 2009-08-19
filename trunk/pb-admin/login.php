<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require_once(SITE_ROOT. './app/configs/db_session.php');
uses("adminer","memberlog","setting");
$adminer = new Adminers();
$memberlog = new Memberlogs();
$setting = new Settings();
$if_set_cp_picture = $setting->field("ab", "aa='cp_picture'");
setvar("IfCpPicture",intval($if_set_cp_picture));
if(!extension_loaded("gd") && $if_set_cp_picture) {
	setvar("LoginError",lgg('no_phpgd')."!");
}
if (isset($_GET['action'])) {
	if ($_GET['action']=="dereg") {
		usetcookie("uladmin", "");
	}
}
if ($_POST['login'] && !empty($_POST['a']['username']) && (!empty($_POST['a']['userpass']))) {
	$r_check = false;
	$auth_check = uaStrCompare(strtolower($_POST['login_auth']),strtolower($_SESSION['authnum_session']));
	if (!$auth_check) {
		session_destroy();
		setvar("LoginError",lgg('auth_error')."!");
	}else{
		unset($_SESSION['authnum_session']);
		$uname = $_POST['a']['username'];
		$upass = $_POST['a']['userpass'];
		$r_check = $adminer->checkUserLogin($uname,$upass);
		if($r_check > 0){
			$g_db->Execute("update ".$adminer->getTable()." set last_login=".$time_stamp." where user_name='$uname'");
			$tAuth = $adminer->userid."|".$adminer->username."|".$adminer->userpass."|".uaIp2Long(uaGetClientIP());
			usetcookie("uladmin", authcode($tAuth));
			//$_SESSION['admin']['current_adminer'] = $uname;
			//$_SESSION['admin']['current_adminer_id'] = $adminer->field("id", "user_name='".$uname."'");
			//$_SESSION['admin']['current_pass'] = md5($upass);

			goto("./index.php");
		}else{
			setvar("LoginError",lgg('login_false').",ErrorCode:".$r_check);
		}
	}

}


template("pb-admin/login");
exit;
?>