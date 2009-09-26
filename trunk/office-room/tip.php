<?php
$inc_path = "../";$ua_sm_compile_dir = "office-room/";
require($inc_path."global.php");
require("session.php");
$referer = (empty($_GET['refer']))? "./index.php":trim($_GET['refer']);
setvar("backUrl",$referer);
if(isset($_GET['id'])){
	if (!empty($tips[$_GET['id']])) {
		setvar("TipResult",$tips[$_GET['id']]);
	}else{
		setvar("TipResult",lgg('action_complete'));
	}
}else{
    setvar("TipResult",lgg('action_complete'));
}
template("tip");
?>