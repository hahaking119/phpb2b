<?php
$inc_path = "../";$ua_sm_compile_dir = "room/";
require($inc_path."global.php");
require("session.php");
uaCheckPermission(2);
require(SITE_ROOT.'./app/include/page.php');
uses("member","companynews", "company");
$companynews = new Companynewses();
$company = new Companies;
$tables = $companynews->getTable(true);
$tpl_file = "news";
$company_id = $company->field("id", "member_id=".$_SESSION['MemberID']);
$conditions = "company_id=".$company_id;
if (empty($company_id)){
	PB_goto("./company.php");
}
$company->checkStatus($company_id);
if ($_GET['action'] == "mod") {
		if(!empty($_GET['id'])){
		$res = $companynews->read("Companynews.id AS ID,title AS Title,content AS Content,created AS CreateDate",$_GET['id']);
		setvar("NewsInfo",$res);
		setvar("ShowCaption","none");
	}
	$tpl_file = "news_edit";
}
if (isset($_POST['save'])) {
	$vals = null;
	$vals['title'] = trim($_POST['title']);
	$vals['content'] = trim($_POST['content']);
	array_walk($vals,"uatrim");
	if(!empty($_POST['newsid'])){
		$vals['modified'] = $time_stamp;
		$companynews->save($vals, "update",$_POST['newsid'],null, " and member_id=".$_SESSION['MemberID']);
		PB_goto("./news.php?action=list");
	}else {
		$vals['created'] = $time_stamp;
		$vals['member_id'] = $_SESSION['MemberID'];
		$vals['company_id'] = $company_id;
		$result = $companynews->save($vals);
		flash("./tip.php", "./news.php");
	}
}
if ($_POST['del']) {
	$result = $companynews->del($_POST['newsid'], $conditions);
	if ($result) {
		flash("./tip.php", "./news.php");
	}else {
		flash("./tip.php", "./news.php");
	}
}
$tmpamount = $companynews->findCount($conditions);
pageft($tmpamount,10);
$fields = "title as CompanynewsTitle,created as CompanynewsCreated,id as CompanynewsId";
setvar("News",$companynews->findAll($fields,$conditions,"id DESC",$firstcount,$displaypg));
setvar("ByPages",$pagenav);
template($tpl_file);
?>