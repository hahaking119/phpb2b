<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './app/configs/db_session.php');
uses("templet", "company");
require(SITE_ROOT.'./app/include/page.php');
require("session_cp.inc.php");
$templet = new Templets();
$company = new Companies();
$conditions = null;
$tpl_file = "templet_index";
function search_templets()
{
	@chdir(BASE_DIR."templates".DS."member");
	$handle = @opendir(BASE_DIR."templates".DS."member");
	while($dir = @readdir($handle))
	{
	if   (is_dir($dir)   and   $dir<>"."   and   $dir<>"..")
	$t[] = strtolower($dir);
	}
	closedir($handle);
	return $t;
}

if ($_GET['action'] == "del" && $_GET['id']) {
	$templet->del($_GET['id'])	;
}
if (isset($_POST['del']) and is_array($_POST['id'])) {
	$result = $templet->del($_POST['id']);
}
if (isset($_POST['save']) && !empty($_POST['templet']['title'])) {
	$vals = array();
	$vals = $_POST['templet'];
	array_walk($vals, "uatrim");
	if ($_POST['id']) {
		$result = $templet->save($vals, "update", $_POST['id']);
	}else{
		$result = $templet->save($vals);
	}
	if($result){
		flash("./alert.php");
	}else{
		flash("./alert.php","./templet.php", null, 0);
	}
}
if($_GET['action'] == "mod"){
	$templet_id = intval($_GET['id']);
	setvar("t",$templet->read(null, $templet_id));
	$tpl_file = "templet_edit";
}elseif($_GET['action'] = "list"){
	$amount = $templet->findCount($conditions);
	//pageft($amount,15);
	//$tmp_templets = $templet->findAll($templet->getFieldAliasNames(), null, " Templet.id DESC",$firstcount,$displaypg);
	$sql = "select Templet.ID as TempletId,Templet.TITLE as TempletTitle,Templet.DESCRIPTION as TempletDescription,Templet.PICTURE as TempletPicture,Templet.STATUS as TempletStatus,Templet.CREATED as TempletCreated,count(Company.style_id) as CompanyStyleStat from ".$templet->getTable(true)." left join ".$company->getTable(true)." on Templet.id=Company.style_id group by Templet.id";
	$tmp_templets = $g_db->GetArray($sql);
	setvar("TempletList",$tmp_templets);
	setvar("Amount",$amount);
	setvar("PageHeader",$page_header);
	setvar("ByPages",$pagenav);
}
template("pb-admin/".$tpl_file);
if ($_GET['action']=="list") {
	$folder_templets = search_templets();
	foreach ($tmp_templets as $key=>$val) {
		$db_templets[] = strtolower($val['TempletTitle']);
	}
}
?>