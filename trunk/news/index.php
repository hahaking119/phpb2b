<?php
$inc_path = "../";
$li = 5;
require($inc_path."global.php");
require(INC_PATH .'xajax/xajaxAIO.inc.php');
require(LIB_PATH .'time.class.php');
uses("news","newstype","htmlcache");
$htmlcache = new Htmlcaches();
$news = new Newses();
$newstype = new Newstypes();
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
	    $imgs_src[] = "img".$i." = new Image ();img".$i.".src='".URL."attachment/".$LatestPictureNews[$j]['picture'].".small.jpg';";
	    $imgs_url[] = "url".$i." = new Image ();url".$i.".src='".URL."news/detail.php?id=".$LatestPictureNews[$j]['id']."';";
	    $j++;
	}
	uaAssign(array("img_count"=>$img_count, "PictureFiles"=>implode("\n", $imgs_src), "PictureTitles"=>implode("\n", $imgs_url)));
	setvar("ImageShow", $smarty->fetch($theme_name."/elements/img_show.html"));
}
require(DATA_PATH.$cookiepre."newstype.inc.php");
setvar("Newstype", $UL_DBCACHE_NEWSTYPE);
setvar("pageDescriptioin", implode(",",$UL_DBCACHE_NEWSTYPE));
setvar("today_mktime",Times::dateConvert(date("d/m/Y"), "/"));
if (isset($_GET['action']) && $_GET['action']=="html") {
	$smarty->MakeHtmlFile('../htmls/news/index.html',$smarty->fetch($theme_name."/news_index.html"), true, "news/index.php");
}
template($theme_name."/news_index");
?>