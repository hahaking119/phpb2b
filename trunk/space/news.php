<?php
if(!defined('IN_PHPB2B')) exit('Not A Valid Entry Point');
require(SITE_ROOT.'./libraries/page.php');
uses("companynews");
$companynews = new Companynewses();
$conditions = " Companynews.company_id=".$companyinfo['ID'];
if ($_GET['news_id']) {
	$tpl_file = "news_detail";
	$info = $companynews->read("*", intval($_GET['news_id'], $conditions));
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
template("../skins/".$tplpath."news");
?>