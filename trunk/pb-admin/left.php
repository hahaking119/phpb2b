<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
header("Content-Type: text/html; charset=".$charset);
require_once(SITE_ROOT. './configs/db_session.php');
require("session_cp.inc.php");
require("menu.php");
setvar("ActionMenus",$menus);
template("left");
?>