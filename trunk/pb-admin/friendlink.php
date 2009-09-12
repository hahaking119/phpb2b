<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './app/configs/db_session.php');
require(SITE_ROOT.'./app/include/page.php');
require("session_cp.inc.php");
if (!class_exists("Friendlinks")) {
	uses("friendlink");
}
$link = new Friendlinks();
$conditions = null;
$tpl_file = "friendlink_index";
if (isset($_POST['save']) && !empty($_POST['link']['title'])) {
	$vals = array();
	$vals = $_POST['link'];
	$lid = intval($_POST['id']);
	if ($lid) {
		$updated = $link->save($vals, "update", $lid);
	} else {
		$vals['created'] = $time_stamp;
		$updated = $link->save($vals);
	}
	if ($updated) {
		flash("./alert.php");
	} else {
		flash("./alert.php","./link.php",null,0);
	}
}
if ($_GET['action'] == "del" && !empty($_GET['id'])) {
	$result = $link->del($_GET['id']);
}

if(isset($_POST['del']) && !empty($_POST['id'])){
	$result = $link->del($_POST['id']);
	if($result){
		flash("alert.php");
	} else{
		flash("alert.php", "friendlink.php", null, 0);
	}
}
if ($_GET['action'] == "mod") {
	$tpl_file = "friendlink_edit";
	if($_GET['id']){
		$fields = "id AS LinkId,title AS LinkTitle,Logo AS LinkLogo,priority,url AS LinkUrl";
	$link_info = $link->read($fields,$_GET['id']);
	setvar("LinkInfo",$link_info);
	}
}else{
	$fields = "id AS LinkId,logo AS LinkLogo,title AS LinkTitle,url AS LinkUrl,created AS LinkCreated ";
	$amount = $link->findCount($conditions, "id");
	pageft($amount,$display_eve_page);
	setvar("LinkList",$link->findAll($fields, $conditions, "id DESC", $firstcount, $displaypg));
	setvar("Amount",$amount);
	setvar("PageHeader",$page_header);
	setvar("ByPages",$pagenav);
}
template($tpl_file);
?>