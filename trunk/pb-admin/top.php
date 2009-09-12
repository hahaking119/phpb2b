<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require_once(SITE_ROOT. './app/configs/db_session.php');
require("session_cp.inc.php");
require("./menu.php");
foreach ($menus as $cur_menu) {
	$top_menus[] = "'".$cur_menu['ename']."'";
}
setvar("ToogleMenus",implode(",",$top_menus));
array_shift($menus);
setvar("ActionMenus",$menus);
template("top");
?>