<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './app/configs/db_session.php');
uses("companynews","company","member");
require(SITE_ROOT.'./app/include/page.php');
require("session_cp.inc.php");
$member = new Members();
$company = new Companies();
$companynews = new Companynewses();
$conditions = null;
$tplname = "companynews_index";
if ($_POST['del'] && is_array($_POST['id'])) {
	if (!$companynews->del($_POST['id'])) {
		flash("./alert.php","./companynews.php",null,0);
	}
}
if ($_GET['action'] == "del" && $_GET['id']) {
	if (!$companynews->del($_GET['id'])) {
		flash("./alert.php","./companynews.php",null,0);
	}
}
if ($_POST['search']) {
	if ($_POST['topic']) $conditions.= " AND Companynews.title like '%".trim($_POST['topic'])."%'";
	if ($_POST['membername']) $conditions.= " AND Member.name='".$_POST['membername']."'";
	if ($_POST['companyname']) $conditions.= " AND Company.company_name like '%".$_POST['companyname']."%'";
}

$fields = "company_id as CompanyId,Companynews.id AS ID,Companynews.title AS Topic,Companynews.status as CompanynewsStatus,Companynews.created AS PublishDate,Companynews.clicked AS Click ";
$amount = $companynews->findCount($conditions,"Companynews.id");
pageft($amount,$display_eve_page);
	$joins = array(
	"Company"=>array("fullTableName"=>$company->getTable(true),"foreignKey"=>"company_id","fields"=>"Company.name as CompanyName"),
	);
setvar("NewsList",$companynews->findAll($fields, $conditions, "Companynews.id DESC ",$firstcount,$displaypg));
if ($_GET['action'] == "mod") {
	if($_GET['id']){
		$nid = intval($_GET['id']);
		$news_info = $companynews->getNewsInfo($nid);
		setvar("NewsInfo",$news_info);
	}
	$tpl_file = "companynews_edit";
}
if ($_POST['createhtml'] && is_array($_POST['newsid'])) {
	die(lgg("not_defined_error"));
	return false;
}
if ($_GET['action'] == "mod") {
	$tplname = "companynews_edit";
}
template("pb-admin/".$tplname);
?>