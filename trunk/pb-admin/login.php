<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require_once(SITE_ROOT. './app/configs/db_session.php');
uses("adminer","memberlog","setting");
$adminer = new Adminers();
$memberlog = new Memberlogs();
$setting = new Settings();
$if_set_cp_picture = $setting->field("valued", "variable='cp_picture'");
setvar("IfCpPicture",intval($if_set_cp_picture));
if(!extension_loaded("gd") && $if_set_cp_picture) {
	setvar("LoginError",lgg('no_phpgd')."!");
}
if (isset($_GET['action'])) {
	if ($_GET['action']=="dereg") {
		usetcookie("uladmin", "");
	}
}
if (isset($_POST['login'])) {
    if (!empty($_POST['a']['username']) && (!empty($_POST['a']['userpass']))) {
    	$r_check = $auth_check = false;
    	if ($if_set_cp_picture) {

    	$auth_check = pb_strcomp(strtolower($_POST['login_auth']),strtolower($_SESSION['authnum_session']));
    	}
    	if ($if_set_cp_picture && !$auth_check) {
    		session_destroy();
    		setvar("LoginError",lgg('auth_error')."!");
    	}else{
    		unset($_SESSION['authnum_session']);
    		$uname = $_POST['a']['username'];
    		$upass = $_POST['a']['userpass'];
    		$r_check = $adminer->checkUserLogin($uname,$upass);
    		if($r_check > 0){
    			$g_db->Execute("update ".$adminer->getTable()." set last_login=".$time_stamp." where user_name='$uname'");
    			$tAuth = $adminer->userid."|".$adminer->username."|".$adminer->userpass."|".pb_get_client_ip();
    			usetcookie("uladmin", authcode($tAuth, "ENCODE"));
    			PB_goto("./index.php");
    		}else{
    			setvar("LoginError",lgg('login_false').",ErrorCode:".$r_check);
    		}
    	}

    }
}
$smarty->template_dir = "template/";
template("login");
exit;
?>