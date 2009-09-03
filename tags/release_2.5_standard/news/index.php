<?php
$inc_path = "../";
$li = 5;
require($inc_path."global.php");
require(INC_PATH .'xajax/xajaxAIO.inc.php');
uses("news","newstype","htmlcache");
$htmlcache = new Htmlcaches();
$news = new Newses();
$newstype = new Newstypes();
$tmp_models = $newstype->index_model;
$xajax = new xajax();
$xajax->configure('javascript URI', URL."app/source/xajax/");
$xajax->register(XAJAX_FUNCTION,  new xajaxUserFunction('rebuildHTML', '../ajax.php'));
$xajax->processRequest();
setvar('xajax_javascript', $xajax->getJavascript());
setvar("focus_news",$g_db->GetRow("select id as NewsId,title as NewsTitle,content as NewsContent from ".$news->getTable()." where if_focus=1"));
$LatestPictureNews = $news->findAll("id,title,picture", "status=1 and picture!=''", "id desc", 0, 5);
if(!empty($LatestPictureNews)){
    $img_count = count($LatestPictureNews);
    $j=0;
	for($i=1; $i<=$img_count; $i++){
	    $imgs[] = "img".$i." = new Image ();img".$i.".src='".URL."attachment/".$LatestPictureNews[$j]['picture'].".small.jpg';";
	    $urls[] = "url".$i." = new Image ();url".$i.".src='".URL."news/detail.php?id=".$LatestPictureNews[$j]['id']."';";
	    $j++;
	}
	uaAssign(array("img_count"=>count($LatestPictureNews), "PictureFiles"=>implode("\n", $imgs), "PictureTitles"=>implode("\n", $urls)));
	setvar("ImageShow", $smarty->fetch($theme_name."/element.img_show.html"));
}
require(DATA_PATH.$cookiepre."newstype.inc.php");
setvar("Newstype", $UL_DBCACHE_NEWSTYPE);
setvar("pageDescriptioin", implode(",",$UL_DBCACHE_NEWSTYPE));
setvar("today_mktime",uaDateConvert(date("d/m/Y")));
if (isset($_GET['action']) && $_GET['action']=="html") {
	$smarty->MakeHtmlFile('../htmls/news/index.html',$smarty->fetch($theme_name."/news_index.html"), true, "news/index.php");
}
template($theme_name."/news_index");
?>