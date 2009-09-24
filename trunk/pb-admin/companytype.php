<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './configs/db_session.php');
require("session_cp.inc.php");
uses("companytype");
require(SITE_ROOT.'./libraries/page.php');
$conditions = null;
$companytype = new Companytypes();
setvar("CompanytypeStatus", explode(",",lgg('yes_no')));
$tpl_file = "companytype_index";
if (isset($_POST['del']) && !empty($_POST['id'])) {
	$result = $companytype->del($_POST['id']);
	if (!$result) {
		flash("./alert.php","./companytype.php",null,0);
	}
}

if (isset($_POST['quickadd']) && !empty($_POST['companytype']['name'])) {
	$vals = array();
	$vals = $_POST['companytype'];
	$result = $companytype->save($vals);
	if (!$result) {
		flash("./alert.php","./companytype.php",null,0);
	}else{
		PB_goto("./companytype.php");
	}
}
if (isset($_POST['save']) && !empty($_POST['c']['name'])) {
	$vals = array();
	$vals = $_POST['c'];
	if (isset($_POST['id'])) {
		$result = $companytype->save($_POST['c'], "update", intval($_POST['id']));
	}else{
		$result = $companytype->save($vals);
	}
	PB_goto("./companytype.php");
}
if ($_GET['action']=="mod") {
	if($_GET['id']){
	$result = $companytype->read("*",intval($_GET['id']));
	setvar("c",$result);
	}
	$tpl_file = "companytype_edit";
}else{
	$amount = $companytype->findCount();
	pageft($amount,$display_eve_page);
	$result = $companytype->findAll("id,name as CompanytypeName,created as CompanytypeCreated",$conditions, " id desc", $firstcount, $displaypg);
	setvar("Lists",$result);

	uaAssign(array("Amount"=>$amount,"PageHeader"=>$page_header,"ByPages"=>$pagenav));
}

template($tpl_file);
?>