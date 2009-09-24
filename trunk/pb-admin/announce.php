<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './configs/db_session.php');
require("fckeditor/fckeditor.php") ;
uses("announcement");
require("session_cp.inc.php");
$announce = new Announcements();
$tpl_file = "announce_index";
if (isset($_POST['del']) && is_array($_POST['id'])) {
	$deleted = $announce->del($_POST['id']);
	if (!$deleted) {
		flash("alert.php",$_SERVER['PHP_SELF'],null,0);
	}
}
if ($_GET['action']=="del" && !empty($_GET['id'])) {
	$announce->del($_GET['id']);
}
if (isset($_POST['save'])) {
	$vals = array();
	$vals = $_POST['announcement'];
	if (!empty($_POST['id'])) {
		$result = $announce->save($vals, "update", $_POST['id']);
	}else{
		$result = $announce->save($vals);
	}
	if (!$result) {
		flash("alert.php","announce.php",null,0);
	}
}
if ($_GET['action'] == "mod") {
	if($_GET['id']){
		$nid = intval($_GET['id']);
		$res= $announce->read(null,$nid);
		setvar("n",$res);
	}
    editor("announcement[message]", $res['AnnouncementMessage'], "FCK_AnnounceMessage");
	$tpl_file = "announce_edit";
}else {
	$conditions = null;
	$amount = $announce->findCount($conditions,"id");
	$fields = "id,id_type,subject as LinkTitle,message";
	setvar("AnnounceList",$announce->findAll($fields, $conditions, "id DESC"));
}
template($tpl_file);
?>