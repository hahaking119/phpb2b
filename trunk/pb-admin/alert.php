<?php
$inc_path = "../";
$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
header("Content-Type: text/html; charset=".$charset);
require(SITE_ROOT. './app/configs/db_session.php');
require("session_cp.inc.php");
if($argc>0){
	$tmp_rf1 = explode("&", trim($argv[0]));
	$tmp_rf2 = explode("refer=", trim($tmp_rf1[0]));
	$referer = $tmp_rf2[1];
	unset($tmp_rf2, $tmp_rf1);
}elseif(isset($_SERVER['REQUEST_URI'])){
	$tmp_rf1 = explode("&", $_SERVER['REQUEST_URI']);
	$tmp_rf2 = explode("refer=", trim($tmp_rf1[0]));
	$referer = $tmp_rf2[1];
	unset($tmp_rf2, $tmp_rf1);
}
setvar("backUrl",$referer);
if(!empty($_GET['pause'])) {
    setvar("pauseTime", intval($_GET['pause']));
    if ($_GET['pause'] ===0) {
        PB_goto($referer);
    }
}
if (isset($_GET['result'])) {
	$alert_img = "action_success.gif";
}else{
	$alert_img = "action_false.gif";
}
setvar("AlertImg",$alert_img);
template("alert");
?>