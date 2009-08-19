<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './app/configs/db_session.php');
uses("news","newstype", "membertype","attachment", "keyword");
require("./fckeditor/fckeditor.php") ;
require(SITE_ROOT.'./app/include/page.php');
require("session_cp.inc.php");
$keyword = new Keywords();
$attachment = new Attachments();
$membertype = new Membertypes();
$news = new Newses();
$newstype = new Newstypes();
$conditions = null;
if (!empty($_GET['type_id'])) {
	$conditions.= " News.type_id=".$_GET['type_id'];
}
$tpl_file = "news_index";
if (isset($_POST['search']) && !empty($_POST['news'])) {
	if ($_POST['news']['keywords']) $conditions.= " AND News.keywords like '%".trim($_POST['news']['keywords'])."%'";
	if ($_POST['news']['source']) $conditions.= " AND News.source like '%".trim($_POST['news']['source'])."%'";
	if ($_POST['news']['title']) $conditions.= " AND News.title like '%".trim($_POST['topic'])."%'";
}
if (isset($_POST['update']) && !empty($_POST['if_focus'])) {
	$g_db->Execute("update ".$news->getTable()." set if_focus=0");
	$g_db->Execute("update ".$news->getTable()." set if_focus=1 where id=".intval($_POST['if_focus']));
}
if (isset($_POST['del']) && is_array($_POST['id'])) {
	$deleted = $news->del($_POST['id']);
	if ($deleted) {
		flash("./alert.php");
	}else {
		flash("./alert.php",null,null,0);
	}
}
if ($_GET['action'] == "del" && !empty($_GET['id'])) {
	$news->del($_GET['id']);
}
if (isset($_POST['save']) && !empty($_POST['news']['title'])) {
	$_POST['news']['content'] = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;', '\"'), array('&', '"', '<', '>', '"'), $_POST['news']['content']);

	$nid = intval($_POST['id']);
	$vals = array();
	$vals = $_POST['news'];
	if(!in_array(0, $_POST['require_membertype']) && !empty($_POST['require_membertype'])){
		$reses = implode(",", $_POST['require_membertype']);
		$vals['require_membertype'] = $reses;
	}elseif(!empty($_POST['require_membertype'])){
		$vals['require_membertype'] = 0;
	}
	if (!empty($_FILES['pic']['name'])) {
        include("../app/include/class.thumb.php");
        $attachment->out_file_dir     = BASE_DIR.'attachment/'.gmdate("Ym");
        $attachment->out_file_name = $time_stamp;
        $attachment->upload_process();
        if ( $attachment->error_no )
        {
            flash("./alert.php","./news.php", lgg("upload_error").$attachment->error_no,0);
        }
        $img = new Image($attachment->saved_upload_name, $attachment->saved_upload_name);
        $img->Thumb(180,65);
        $attachment->imageWaterMark($attachment->saved_upload_name, "../images/watermark.png");
        $vals['picture'] = gmdate("Ym")."/".$attachment->parsed_file_name;
	}
	if($nid){
	    unset($vals['keywords']);
		if(empty($_POST['creattime']) || ($_POST['creattime']=="None")){
			$vals['created'] = $time_stamp;
		}else{
			$vals['created'] = uaDateConvert($_POST['creattime']);
		}
		$vals['modified'] = $time_stamp;
		$result = $news->save($vals, "update", $nid);
	}else{
		if(empty($_POST['creattime']) || ($_POST['creattime']=="None")){
			$vals['created'] = $time_stamp;
		}else{
			$vals['created'] = uaDateConvert($_POST['creattime']);
		}
		$result = $news->save($vals);
        $new_id = $g_db->Insert_ID();
        uses("stat");
        $stat = new Stats();
        $stat->Add("news");
        $keyword->setKeywordId($vals['keywords'], $new_id, 'newses');
        $g_db->Execute("update ".$tb_prefix."newses set keywords='".$keyword->getKeywordId()."' where id=".$new_id);
	}
	if ($result) {
		flash("./alert.php","./news.php",null);
	}else{
		flash("./alert.php","./news.php",null,0);
	}
}
$tables = $news->getTable(true)." ";
if ($_GET['action'] == "mod") {
	$result = $membertype->findAll("id as MembertypeId,name as MembertypeName",$conditions, " id desc", 0,15);
	$user_types = array();
	foreach ($result as $key=>$val) {
		$user_types[$val['MembertypeId']] = $val['MembertypeName'];
	}
	setvar("Membertypes", $user_types);
	if($_GET['id']){
		$nid = intval($_GET['id']);
		$news_info = $news->read($fields,$nid);
		setvar("n",$news_info);
	}
	editor("news[content]", $news_info['NewsContent'], "FCK_NEWSCONTENT");
	$parent_types = $newstype->findAll("id AS NewstypeId,name AS NewstypeName", null, "id DESC", 0,100);
	if (empty($parent_types)) {
		setvar("nonewstype", lgg("ready_to_add_type"));
	}
	foreach ($parent_types as $key=>$val) {
		$tmp_v[$val['NewstypeId']] = $val['NewstypeName'];
	}
	setvar("AllParents",$tmp_v);
	$tpl_file = "news_edit";
}else{
	$fields = "News.id AS ID,News.title AS Topic,News.created AS PublishDate,News.clicked AS Click,News.html_file_id AS HtmlID,News.picture as NewsPicture,News.if_focus as IfFocus ";
	$amount = $news->findCount($conditions);
	pageft($amount,$display_eve_page);
$joins = array(
	"Newstype"=>array("fullTableName"=>$newstype->getTable(true),"foreignKey"=>"type_id","fields"=>"Newstype.name as NewstypeName,Newstype.id as NewstypeId")
	);
	setvar("NewsList",$news->findAll($fields, $conditions, "News.id DESC ",$firstcount,$displaypg));
	unset($joins);
	$parent_newstypes = $newstype->findAll("id AS NewstypeId,name AS NewstypeName,parent_id as ParentId", null, "id DESC", 0,25);
	foreach ($parent_newstypes as $key=>$val) {
		$tmp_v[$val['NewstypeId']] = $val['NewstypeName'];
	}
	setvar("AllParents",$tmp_v);
	uaAssign(array("Amount"=>$amount,"PageHeader"=>$page_header,"ByPages"=>$pagenav));
}
if (isset($_POST['createhtml']) && is_array($_POST['newsid'])) {
	die(lgg("not_defined_error"));
	return false;
}
template("pb-admin/".$tpl_file);
?>