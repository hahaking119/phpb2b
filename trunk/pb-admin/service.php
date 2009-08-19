<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './app/configs/db_session.php');
uses("service","adminer");
require(SITE_ROOT.'./app/include/page.php');
require("session_cp.inc.php");
$adminer = new Adminers();
$service = new Services();
$conditions = null;
$tpl_file = "service_index";
setvar("ServiceStatus",$service->status);
setvar("ServiceTypes",$service->types);
if($_GET['action'] == "view"){
	$sql = "SELECT Service.* FROM ".$service->getTable(true)." WHERE Service.id=".$_GET['id'];
	$res = $g_db->GetRow($sql);
	if(isset($res['type_id']) && $res['type_id']==9) {
		$tmp_siteinfo = unserialize($res['content']);
		$tmp_content = "网站名称:".$tmp_siteinfo['name'];
		$tmp_content.= "<br />网站地址:".$tmp_siteinfo['url'];
		$tmp_content.= "<br />网站描述:".$tmp_siteinfo['description'];
		$tmp_content.= "<br />联系Email:".$tmp_siteinfo['email'];
		$tmp_content.= "<br />网站logo图片:".$tmp_siteinfo['logo'];
		$res['content'] = $tmp_content;
	}
	if (empty($res)) {
		flash("./alert.php","./service.php","没有此记录",0);
	}else {
		setvar("s",$res);
	}
	$tpl_file = "service_edit";
}
if (isset($_POST['save']) && !empty($_POST['service'])) {
	$vals = array();
	$vals = $_POST['service'];
	$vals['adminer_user_name'] = $current_adminer;
	array_walk($vals,"uatrim");
	$service->save($vals, "update", $_POST['id']);
}
if($_GET['action'] = "list"){
	
	$amount = $service->findCount($conditions,"Service.id");
	pageft($amount,$display_eve_page);

	$fields = "Service.id AS ID,Service.title AS Title,Service.nick_name AS UserName,Service.email AS Email,Service.status AS Status,Service.created AS PutDate,Service.type_id AS Type,Service.content AS Content ";
	setvar("ServiceList",$service->findAll($fields, $conditions, "Service.id DESC ",$firstcount,$displaypg));
	setvar("Amount",$amount);
	setvar("PageHeader",$page_header);
	setvar("ByPages",$pagenav);
}
if (isset($_REQUEST['del'])){
	$deleted = false;
	if(!empty($_POST['id'])) {
		$deleted = $service->del($_POST['id']);
	}
	if(!empty($_GET['id'])){
		$deleted = $service->del($_GET['id']);
	}
	if($deleted) goto("./service.php");
	else
	{
		flash("./alert.php","./service.php",null,0);
	}
}

template("pb-admin/".$tpl_file);
?>