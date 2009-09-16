<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './app/configs/db_session.php');
uses("expotype","member","company");
require(SITE_ROOT.'./libraries/page.php');
require("session_cp.inc.php");
$expotype = new Expotypes();
$member = new Members();
$company = new Companies();
$conditions = null;
$tpl_file = "fairtype_index";
if (isset($_POST['del']) && !empty($_POST['id'])){
	$deleted = false;
	$result = $expotype->del($_POST['id']);
	if(!$result)
	{
		flash("./alert.php","./fairtype.php?action=list",null,0);
	}
}
if ($_GET['action']=="del" && !empty($_GET['id'])){
	$deleted = false;
	$result = $expotype->del($_GET['id']);
	if(!$result)
	{
		flash("./alert.php","./fairtype.php?action=list",null,0);
	}
}
if (isset($_POST['save']) && !empty($_POST['Expotype']['name'])) {
	$vals = array();
	$vals = $_POST['Expotype'];
	$primary_id = intval($_POST['id']);
	$result = $expotype->save($vals);
}
if ($_GET['action'] == "mod") {
	if($_GET['id']){
		$tmp_info = $expotype->read(null,intval($_GET['id']));
		setvar("one",$tmp_info);
	}
	$tpl_file = "fairtype_edit";
}else{
	$amount = $expotype->findCount();
	pageft($amount,$display_eve_page);
	$fields = "id,Expotype.name as ExpotypeName";
	$result = $expotype->findAll($fields,null,null,$firstcount,$displaypg);
	setvar("Lists",$result);
	setvar("Amount",$amount);
	setvar("PageHeader",$page_header);
	setvar("ByPages",$pagenav);
}


template($tpl_file);
?>