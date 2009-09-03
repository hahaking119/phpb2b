<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './app/configs/db_session.php');
require("session_cp.inc.php");
uses("htmlcache");
$htmlcache = new Htmlcaches();
$tpl_file = "htmlcache_index";
if (isset($_POST['del_x']) && !empty($_POST['id'])) {
	$htmlcache->del($_POST['id'])	;
}
$result = $htmlcache->findAll(null, null, "id desc");
setvar("TOKEN",  md5(AUTH_KEY));
setvar("Lists", $result);
//:~
template("pb-admin/".$tpl_file);
?>