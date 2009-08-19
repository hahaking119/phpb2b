<?php
$inc_path = "../";
$li = 5;
require($inc_path."global.php");
uses("news");
$news = new Newses();
$conditions = null;
$nid = intval($_GET['id']);
if(!empty($_GET['title'])){
	$nid = $news->field("id", "title='".urldecode(trim($_GET['title'])));
}
$_positions[] = lgg("info_center");
if (!empty($nid)) {
    require(DATA_PATH.$cookiepre."newstype.inc.php");
	$news->clicked(intval($nid));
	$info = $news->read("require_membertype,".$news->common_cols,$nid);
	if($info['require_membertype']!=0){
		$reses = explode(",", $info['require_membertype']);
		if(!in_array($ua_user['user_type'], $reses)){
			alert(sprintf(lgg("more_permission"), urlencode($info['NewsTitle'])));
		}
	}
	if(!empty($info['Keywords'])){
    	$tmpkeys = $g_db->GetArray("select title from ".$tb_prefix."keywords where id in (".$info['Keywords'].")");
    	$info['Keywords'] = $tmpkeys;
	}
	$similiaradd.= "News.title='".$info['NewsTitle']."' ";
	setvar("SimiliarNews",$news->findAll($news->common_cols,$similiaradd,"News.id DESC",0,10));
	//$info['Keywords'] = implode(" ",$tmpkeys);
	setvar("NewsInfo",$info);
	$_titles[] = $info['NewsTitle'];
	$_positions[] = $info['NewsTitle'];
	$_titles[] = $UL_DBCACHE_NEWSTYPE[$info['TypeID']];
	$_positions[] = $UL_DBCACHE_NEWSTYPE[$info['TypeID']];
}else{
    alert(lgg("data_not_exists"));
}
$_titles[] = "行业资讯";
$news->setPageTitle($_titles, $_positions);
uaAssign(array("pageTitle"=>$news->title, "pagePosition"=>$news->position));
$hotnews = $news->findAll($news->common_cols,$conditions,"News.clicked DESC",0,10);
setvar("latestnews",$hotnews);
template($theme_name."/news_detail");
?>