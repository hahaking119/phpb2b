<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './app/configs/db_session.php');
uses("helptype","help");
require(SITE_ROOT.'./libraries/page.php');
require("session_cp.inc.php");
$help = new Helps();
$helptype = new Helptypes();
$tpl_file = "help_index";
$status = explode(",",lgg('if_valid'));
setvar("HelpStatus",$status);
$help_types = $helptype->findAll("id AS helptypeId,ha AS helptypeName",null, "id DESC", 0,100);
foreach ($help_types as $key=>$val) {
	$tmp_v[$val['helptypeId']] = $val['helptypeName'];
}
setvar("AllHelpTypes",$tmp_v);
if (isset($_POST['search']) && !empty($_POST['help']['title'])) {
	$searchkeywords = $_POST['help']['title'];
	$conditions = " AND Help.ha like '%".$searchkeywords."%'";
}
if(isset($_POST['save']) && !empty($_POST['help']['ha'])){
	$vals = null;
	$vals = $_POST['help'];
	if($_POST['id']){
		$result = $help->save($vals, null, "update", $_POST['id']);
	}else{
		$vals['he'] = $time_stamp;
		$result = $help->save($vals);
	}
	if ($result) {
		flash("./alert.php","./help.php");
	}
}
if($_GET['action'] == "mod"){
	if(!empty($_GET['id'])){
		setvar("h",$help->read("*",$_GET['id']));
	}
	$tpl_file = "help_edit";
}
if($_GET['action'] = "list"){
	$tables = $help->getTable(true)." ";
	$amount = $help->findCount($conditions,"id");
	pageft($amount,$display_eve_page);
	if(!empty($conditions)) $conditions = "where 1 ".$conditions;
	$sql = "SELECT Help.id AS HelpId,Help.ha AS HelpTitle,Help.hb AS HelpContent,Help.hd AS HelpStatus ,Helptype.ha AS HelpTypeTitle FROM ".$tables." LEFT JOIN ".$helptype->getTable(true)." ON Help.helptype_id=Helptype.id ".$conditions." ORDER BY Help.id DESC LIMIT $firstcount,$displaypg";
	setvar("HelpList",$g_db->GetAll($sql));
	uaAssign(array(
	"Amount"=>$amount,
	"PageHeader"=>$page_header,
	"ByPages"=>$pagenav));
}
if ($_REQUEST['del']){
	$deleted = false;
	if(!empty($_POST['helpid'])) {
		$deleted = $help->del($_POST['helpid']);
	}
	if(!empty($_GET['id'])){
		$deleted = $help->del($_GET['id']);
	}
	flash("./alert.php","./help.php",null,$deleted);
}
template($tpl_file);
?>