<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './app/configs/db_session.php');
require("./fckeditor/fckeditor.php") ;
require(SITE_ROOT.'./libraries/page.php');
require("session_cp.inc.php");
$conditions = null;
$tpl_file = "userpage_index";
if (isset($_POST['del']) && is_array($_POST['id'])) {
	$deleted = $userpage->del($_POST['id']);
	if (!$deleted) {
		flash("./alert.php",$_SERVER['PHP_SELF'],null,0);
	}
}
if (isset($_POST['save'])) {
	$vals = array();
	$vals = $_POST['userpage'];
	if (!empty($_POST['id'])) {
		$vals['modified'] = $time_stamp;
		$result = $userpage->save($vals, "update", $_POST['id']);
	}else{
		$vals['created'] = $time_stamp;
		$result = $userpage->save($vals);
	}
	if (!$result) {
		flash("./alert.php","./userpage.php",null,0);
	}
}
if ($_GET['action'] == "mod") {
	if(!empty($_GET['id'])){
		$nid = intval($_GET['id']);
		$res= $userpage->read(null,$nid);
		setvar("n",$res);
	}
	editor("userpage[uc]", $res['UserpageUc'], "FCK_CONTENT");
	$tpl_file = "userpage_edit";
}else {
	$amount = $userpage->findCount();
	pageft($amount,$display_eve_page);
	$fields = "id AS ID,ua as PageTitle,ub as BriefName, ud as PageOrder, ug as TargetUrl, uf as ShowName";
	setvar("lists",$userpage->findAll($fields, $conditions, "id DESC", $firstcount, $displaypg));
	uaAssign(array("Amount"=>$amount,"PageHeader"=>$page_header,"ByPages"=>$pagenav));
}
template($tpl_file);
?>