<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './app/configs/db_session.php');
$tplname = "company_message";
uses("companymessage","member","company");
require(SITE_ROOT.'./app/include/page.php');
require("session_cp.inc.php");
$member = new Members();
$companymessage = new Companymessages();
$conditions = null;
$table['company_message'] = $companymessage->getTable(true);
$table['member'] = $member->getTable(true);
$tpl_file = "companymessage_index";
if ($_POST['search']) {
	if ($_POST['topic']) $conditions.= " AND Companymessage.title like '%".trim($_POST['topic'])."%'";
}
if ($_POST['delnews'] && is_array($_POST['id'])) {
	$deleted = $companymessage->del($_POST['id']);
	if (!$deleted) {
		flash("./alert.php","./companymessage.php",null,0);
	}
}

if($_GET['action'] == "view"){
	if($_GET['id']){
		$nid = intval($_GET['id']);
		$sql = "SELECT Companymessage.*,m1.username AS FromUserName,m2.username As ToUserName from ".$table['company_message']." LEFT JOIN ".$member->getTable()." AS m1 ON m1.id=Companymessage.from_member_id LEFT JOIN ".$member->getTable()." AS m2 ON m2.id=Companymessage.to_member_id where Companymessage.id=".$nid;
		$news_info = $g_db->GetRow($sql);
		setvar("c",$news_info);
	}
	$tpl_file = "companymessage_view";
}else{
	$fields = "Member.username AS MemberUsername,Member.id AS MemberId,Companymessage.id AS ID,Companymessage.title AS Topic,Companymessage.created AS PublishDate ";
	$sql = "SELECT ".$fields.",Member.username FROM ".$table['company_message']." LEFT JOIN ".$table['member']." ON Companymessage.from_member_id=Member.id";
	$amount = $g_db->GetOne("select count(id) from ".$table['company_message']);
	pageft($amount,$display_eve_page);
	$sql.=" LIMIT $firstcount,$displaypg";
	setvar("MessageList",$g_db->GetAll($sql));
}
template("pb-admin/".$tpl_file);
?>