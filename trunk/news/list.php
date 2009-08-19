<?php
$inc_path = "../";
$li = 5;
require($inc_path."global.php");
uses("news","newstype");
require(SITE_ROOT.'./app/include/page.php');
$news = new Newses();
$newstype = new Newstypes();
$conditions = null;
if(isset($_GET['search_news']) && !empty($_GET['news']['title'])){
	//search news.
	$title = trim($_GET['news']['title']);
	$conditions[] = "News.title like '%".$title."%'";
	$_titles[] = sprintf(lgg("search_info_center"), $title);
	$_positions[] = sprintf(lgg("search_info_center"), $title);
}
if(isset($_GET['type_id'])){
	$newstype_id = intval($_GET['type_id']);
	$newstype_name = $newstype->find($newstype_id, "name", "id");
	$conditions[] = "News.type_id=".$newstype_id;
	$_titles[] = sprintf(lgg("view_info_center"), $newstype_name);
	$_positions[] = sprintf(lgg("view_info_center"), $newstype_name);
	setvar("NewstypeName", $newstype_name);
}
if(!empty($conditions)){
	$conditions = implode(" and ", $conditions);
}
$fields = "News.id AS NewsId,News.title AS NewsTitle";
$amount = $news->findCount($conditions);
pageft($amount,10, $type_ids = (isset($_GET['type_id']))?'list.php?type_id='.intval($_GET['type_id']):null);
setvar("ListNews",$news->findAll($fields, $conditions, "News.id DESC", $firstcount, $displaypg));
$tmp_latest = $news->findAll($news->common_cols,$conditions,"News.id DESC",0,10);
setvar("LatestNews",$tmp_latest);
$hotnews = $news->findAll($news->common_cols,$conditions,"News.clicked DESC",0,10);
setvar("HotNews",$hotnews);
$news->setPageTitle($_titles, $_positions);
uaAssign(array("ByPages"=>$pagenav,"Li"=>$li,"pageTitle"=>$news->title, "pagePosition"=>$news->position));
template($theme_name."/news_list");
?>