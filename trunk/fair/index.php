<?php
$inc_path = "../";
$li = 7;
$expo_newstype_id = 13;
require($inc_path."global.php");
require(SOURCE_PATH .'xajax/xajaxAIO.inc.php');
uses("expo", "expotype", "htmlcache", "news");
$expo = new Expoes();
$news = new Newses();
$expotype = new Expotypes();
$htmlcache = new Htmlcaches();
$xajax = new xajax();
$xajax->configure('javascript URI', URL."libraries/source/xajax/");
$xajax->processRequest();
require(CACHE_PATH.$cookiepre."area.inc.php");
setvar('xajax_javascript', $xajax->getJavascript());
setvar("today_mktime", mktime(0,0,0,date("m") ,date("d"),date("Y")));
$_titles[] = lgg("expo_channel");

$fields = "Expo.ea as ExpoName,type_id as TypeId,province_id as ProvinceId,city_id as CityId,Expo.id as ExpoId,Expo.eb as ExpoPosted,Expo.ed as ExpoCreated,Expo.eg as LastDate,Expo.picture as ExpoPicture";
setvar("LatestExpo", $expo->findAll($fields, null, "Expo.id desc", 0, 8));

$fields = "Expo.ea as ExpoName,type_id as TypeId,province_id as ProvinceId,city_id as CityId,Expo.id as ExpoId,Expo.eb as ExpoPosted,Expo.ed as ExpoCreated,Expo.eg as LastDate,Expo.picture as ExpoPicture";
setvar("RecommendExpo", $expo->findAll($fields, "if_recommend=1", "Expo.id desc", 0, 8));

setvar("PictureExpo", $picture_expo = $expo->findAll($fields, "Expo.picture!=''", "Expo.id desc", 0, 8));

setvar("ExpoNewstypeId", $expo_newstype_id);
$fields = "News.id AS NewsId,News.title as NewsTitle,html_file_id,picture as NewsPicture";
setvar("ExpoNews", $expo_news = $news->findAll($fields, "News.type_id=".$expo_newstype_id, "News.id desc", 0, 16));
if(!empty($picture_expo)){
	foreach($picture_expo as $val){
		$tmp1['links'][] = URL."fair/detail.php?id=".$val['ExpoId'];
		$tmp1['files'][] = URL."attachment/".$val['ExpoPicture'].".small.jpg";
		$tmp1['titles'][] = $val['ExpoName'];
	}
	uaAssign(array("PictureLinks"=>implode("|", $tmp1['links']), "PictureFiles"=>implode("|", $tmp1['files']), "PictureTitles"=>implode("|", $tmp1['titles'])));
}
$expotype_res = $g_db->GetAll("select id as OptionId,name as OptionName from {$tb_prefix}expotypes");
$expotype_res = UaController::generateList($expotype_res);
setvar("Expotypes", $expotype_res);
if ($UL_DBCACHE_AREAS) {
	setvar("Areas", $UL_DBCACHE_AREAS);
}
$expo->setPageTitle($_titles);
setvar("pageTitle", $expo->title);
template($theme_name."/fair_index");
?>