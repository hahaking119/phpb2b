<?php
require($inc_path .APP_NAME. 'include/inc.discuz.php');
require(SITE_ROOT. './app/configs/db_session.php');
require(SITE_ROOT. './app/include/func.checksubmit.php');
$office_theme_name = "room";
/**
 * invite register
 */
$check_invite_code = false;
$register_type = $g_db->GetOne("select ab from ".$tb_prefix."settings where aa='register_type'");
if ($register_type=="open_invite_reg"){
    setvar("IfInviteCode", true);
}
if (empty($_SESSION['MemberID']) || empty($_SESSION['MemberName'])) {
	uclearcookies();
	PB_goto($inc_path."user/logging.php?referer=".urlencode(uaGetHost().$PHP_SELF));
}

function uaCheckPermission($request_level, $break = 1) {
	$tmp_action = null;
	global $ua_user;
	if (!empty($ua_user['user_level'])) {
		$tmp_action = $ua_user['user_level'];
		if($tmp_action<$request_level){
			PB_goto("./tip.php", false);
		}else{

		}
	}else{
		die("Something Wrong!");
	}
}

?>