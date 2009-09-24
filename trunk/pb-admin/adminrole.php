<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './configs/db_session.php');
uses("adminrole","adminer");
require("session_cp.inc.php");
$adminrole = new Adminroles();
$adminer = new Adminers();
$conditions = null;
template("adminrole_index");
?>