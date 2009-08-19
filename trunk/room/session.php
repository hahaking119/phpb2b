<?php
require($inc_path .APP_NAME. 'include/inc.discuz.php');
require(SITE_ROOT. './app/configs/db_session.php');
require(SITE_ROOT. './app/include/func.checksubmit.php');
$office_theme_name = "room";
if (empty($_SESSION['MemberID']) || empty($_SESSION['MemberName'])) {
	uclearcookies();
	goto($inc_path."user/logging.php?referer=".urlencode(uaGetHost().$PHP_SELF));
}

function uaCheckPermission($request_level, $break = 1) {
	$tmp_action = null;
	global $ua_user;
	if (!empty($ua_user['user_level'])) {
		$tmp_action = $ua_user['user_level'];
		if($tmp_action<$request_level){
			goto("./tip.php", false);
		}else{

		}
	}else{
		die("Something Wrong!");
	}
}

?>