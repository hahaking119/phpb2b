<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './configs/db_session.php');
uses("helptype");
require(SITE_ROOT.'./libraries/page.php');
require("session_cp.inc.php");
$helptype = new Helptypes();
$tpl_file = "helptype_index";
setvar("TypeStatus", explode(",",lgg('yes_no')));
$parent_types = $helptype->findAll("id AS helptypeId,ha AS helptypeName", "hc=0", "id DESC", 0,100);
foreach ($parent_types as $key=>$val) {
	$tmp_v[$val['helptypeId']] = $val['helptypeName'];
}
setvar("AllParents",$tmp_v);
if (isset($_POST['search']) && !empty($_POST['helptype']['title'])) {
	$conditions = " AND ha like '%".trim($_POST['helptype']['title'])."%'";
}
if (isset($_POST['del']) && is_array($_POST['id'])) {
	$deleted = $helptype->del($_POST['id']);
	if (!$deleted) {
		flash("./alert.php",$_SERVER['PHP_SELF'],null,0);
	}
}
if ($_GET['action']=="del" && !empty($_GET['id'])) {
	$helptype->del($_GET['id']);
}
if (isset($_POST['save'])) {
	$vals = array();
	$vals = $_POST['helptype'];
	if (!empty($_POST['id'])) {
		$result = $helptype->save($vals, "update", $_POST['id']);
	}else{
		$result = $helptype->save($vals);
	}
	if (!$result) {
		flash("./alert.php","./helptype.php",null,0);
	}
}
if ($_GET['action'] == "mod") {
	if($_GET['id']){
		$nid = intval($_GET['id']);
		$res= $helptype->read(null,$nid);
		setvar("n",$res);
	}
	$tpl_file = "helptype_edit";
}else {
	$conditions = null;

	$amount = $helptype->findCount($conditions,"id");
	pageft($amount,$display_eve_page);
	$fields = "id AS HelptypeId,ha AS HelptypeTitle,hd AS HelptypeStatus";
	setvar("helptypeList",$helptype->findAll($fields, $conditions, "id DESC", $firstcount, $displaypg));
	uaAssign(array("Amount"=>$amount,"PageHeader"=>$page_header,"ByPages"=>$pagenav));
}
template($tpl_file);
?>