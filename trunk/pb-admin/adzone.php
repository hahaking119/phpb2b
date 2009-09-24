<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './configs/db_session.php');
require("session_cp.inc.php");
uses("adzone");
require(SITE_ROOT.'./libraries/page.php');
$tpl_file = "adzone_index";
$adzone = new Adzones();
$conditions = null;

if ($_GET['action'] == "makejs" && isset($_GET['id'])) {
	setvar("XMLDATA","<a name=\"ad_".$_GET['id']."\"><script language=\"javascript\" src=\"<{\$UrlContainer.common}>js/adv.php?zid=".$_GET['id']."\"></script>");
	template("industry_xml");
	exit;
}
if (isset($_POST['save'])) {
	$vals = $_POST['adzone'];
	$zone_id = $_POST['id'];
	if (empty($vals['what'])) {
		$vals['what'] = 1;
	}
	if (!empty($zone_id)) {
		$result = $adzone->save($vals, "update", $zone_id);
	}else{
		$vals['created'] = $time_stamp;
		$result = $adzone->save($vals);
	}
	if (!$result) {
		flash("./alert.php", null, lgg('action_false'), 0, null, "./adzone.php?action=list");
	}else{
		flash("./alert.php", null, null, 1, null, "./adzone.php?action=list");
	}
}
if (isset($_POST['del']) && !empty($_POST['id'])) {

	$adzone->del($_POST['id']);
}
if ($_GET['action'] == "mod") {
	if (!empty($_GET['id'])) {
		$result = $adzone->read(null, $_GET['id']);
		setvar("info",$result);
	}
	$tpl_file = "adzone_edit";
}
$amount = $adzone->findCount();
pageft($amount,$display_eve_page);
$result = $adzone->findAll("*",$conditions, " id desc", $firstcount, $displaypg);
setvar("Lists",$result);

uaAssign(array("Amount"=>$amount,"PageHeader"=>$page_header,"ByPages"=>$pagenav));

template($tpl_file);
?>