<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './app/configs/db_session.php');
uses("annoucement");
require("session_cp.inc.php");
$announce = new Announcements();
$tpl_file = "announce_index";
if ($_POST['del'] && is_array($_POST['id'])) {
	$deleted = $announce->del($_POST['id']);
	if (!$deleted) {
		flash("./alert.php",$_SERVER['PHP_SELF'],null,0);
	}
}
if ($_GET['action']=="del" && !empty($_GET['id'])) {
	$announce->del($_GET['id']);
}
if ($_POST['save']) {
	$vals = array();
	$vals = $_POST['helptype'];
	if (!empty($_POST['id'])) {
		$result = $announce->save($vals, "update", $_POST['id']);
	}else{
		$result = $announce->save($vals);
	}
	if (!$result) {
		flash("./alert.php","./helptype.php",null,0);
	}
}
if ($_GET['action'] == "mod") {
	if($_GET['id']){
		$nid = intval($_GET['id']);
		$res= $announce->read(null,$nid);
		setvar("n",$res);
	}
	$tpl_file = "announce_edit";
}else {
	$conditions = null;
	$amount = $announce->findCount($conditions,"id");
	$fields = "id as AnnouncementId,id_type,subject as LinkTitle,message";
	setvar("AnnounceList",$announce->findAll($fields, $conditions, "id DESC"));
}
template("pb-admin/".$tpl_file);
?>