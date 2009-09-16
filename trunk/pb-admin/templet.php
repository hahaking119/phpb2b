<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './app/configs/db_session.php');
uses("templet", "company", "membertype");
require(SITE_ROOT.'./libraries/page.php');
require("session_cp.inc.php");
$templet = new Templets();
$company = new Companies();
$membertype = new Membertypes();
$conditions = null;
$tpl_file = "templet_index";
$page_header = $pagenav = null;
$skin_dir = BASE_DIR."skins";
function search_templets($skin_dir)
{
	@chdir($skin_dir);
	$handle = @opendir($skin_dir);
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
	if(!in_array(0, $_POST['require_membertype']) && !empty($_POST['require_membertype'])){
		$reses = implode(",", $_POST['require_membertype']);
		$vals['require_membertype'] = $reses;
	}elseif(!empty($_POST['require_membertype'])){
		$vals['require_membertype'] = 0;
	}
	if (isset($_POST['id'])) {
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
	$tmpMembertypes = $membertype->findAll("id as MembertypeId,name as MembertypeName",$conditions, " id desc", 0,15);
	$user_types = array();
	foreach ($tmpMembertypes as $key=>$val) {
		$user_types[$val['MembertypeId']] = $val['MembertypeName'];
	}
	setvar("Membertypes", $user_types);
	$tpl_file = "templet_edit";
}elseif($_GET['action'] = "list"){
	$amount = $templet->findCount($conditions);
	$sql = "select Templet.ID as TempletId,Templet.TITLE as TempletTitle,Templet.DESCRIPTION as TempletDescription,Templet.PICTURE as TempletPicture,Templet.STATUS as TempletStatus,Templet.CREATED as TempletCreated,count(Company.style_id) as CompanyStyleStat from ".$templet->getTable(true)." left join ".$company->getTable(true)." on Templet.id=Company.style_id group by Templet.id";
	$tmp_templets = $g_db->GetArray($sql);
	setvar("TempletList",$tmp_templets);
	setvar("Amount",$amount);
	setvar("PageHeader",$page_header);
	setvar("ByPages",$pagenav);
}
template($tpl_file);
if ($_GET['action']=="list") {
	$folder_templets = search_templets($skin_dir);
	foreach ($tmp_templets as $key=>$val) {
		$db_templets[] = strtolower($val['TempletTitle']);
	}
}
?>