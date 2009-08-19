<?php
if(!defined('IN_UALINK')) exit('Access Denied');
require(SITE_ROOT.'./app/include/page.php');
uses("companynews");
$companynews = new Companynewses();
require("member/menu.php");
$conditions = " Companynews.company_id=".$companyinfo['ID'];
$tpl_file = "news";
if ($_GET['id']) {
	$tpl_file = "news_detail";
	$info = $companynews->read("*", intval($_GET['id'], $conditions));
	if (empty($info)) {
		alert(lgg('data_not_exists'));
	}
	setvar("n",$info);
}else {
	$tmpamount = $companynews->findCount($conditions,"Companynews.id");
	pageft($tmpamount,10);
	setvar("News",$companynews->findAll($companynews->common_cols,$conditions,"Companynews.id DESC",$firstcount,$displaypg));
	setvar("ByPages",$pagenav);
}
template($tplpath.$tpl_file);
?>