<?php
$inc_path = "../";
$li = 5;
require($inc_path."global.php");
uses("news","newstype");
require(SITE_ROOT.'./libraries/page.php');
require(DATA_PATH.$cookiepre."newstype.inc.php");
$news = new Newses();
$newstype = new Newstypes();
$conditions = null;
if(isset($_GET['searchkeywords']) && !empty($_GET['skeyword'])){
	//search news.
	$title = trim($_GET['skeyword']);
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
$fields = "News.id AS NewsId,News.title AS NewsTitle,News.created as CreateDate,News.type_id as TypeId";
$amount = $news->findCount($conditions);
pageft($amount,10, $type_ids = (isset($_GET['type_id']))?'list.php?type_id='.intval($_GET['type_id']):null);
setvar("ListNews",$news->findAll($fields, $conditions, "News.id DESC", $firstcount, $displaypg));
$tmp_latest = $news->findAll($news->common_cols,$conditions,"News.id DESC",0,10);
setvar("LatestNews",$tmp_latest);
$hotnews = $news->findAll($news->common_cols,$conditions,"News.clicked DESC",0,10);
setvar("HotNews",$hotnews);
$news->setPageTitle($_titles, $_positions);
uaAssign(array("ByPages"=>$pagenav,"Li"=>$li,"pageTitle"=>$news->title, "pagePosition"=>$news->position));
setvar("Newstypes",$UL_DBCACHE_NEWSTYPE);
template($theme_name."/news_list");
?>