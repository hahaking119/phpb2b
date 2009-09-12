<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './app/configs/db_session.php');
require("session_cp.inc.php");
uses("adzone","member","keyword");
require(SITE_ROOT.'./app/include/page.php');
$tpl_file = "keyword_index";
$keyword = new Keywords();
$member = new Members();
$keyword_types = array();
setvar("KeywordStatus", explode(",",lgg('yes_no')));
foreach ($nav as $li_id=>$keyword_name) {
	$keyword_types[$li_id] = $keyword_name['cname'];
}
setvar("KeywordTypes",$keyword_types);
if (isset($_POST['save'])) {
	$vals = $_POST['keyword'];
	$keyword_id = $_POST['id'];
	if (!empty($keyword_id)) {
		$result = $keyword->save($vals, "update", $keyword_id);
	}else{
		$vals['created'] = $time_stamp;
		$result = $keyword->save($vals);
	}
	if (!$result) {
		flash("./alert.php","keyword.php", lgg("action_false"),0);
	}else{
		flash("./alert.php","./keyword.php");
	}
}
if (isset($_POST['del_x']) && !empty($_POST['id'])) {
	$keyword->del($_POST['id']);
}
if ($_GET['action'] == "del" && !empty($_GET['id'])) {
	$keyword->del($_GET['id'])	;
}
if (!empty($_POST['status']) && !empty($_POST['id'])) {
	if(isset($_POST['status']['y'])){
		$result = $keyword->check($_POST['id'], 1);
	}elseif (isset($_POST['status']['n'])){
		$result = $keyword->check($_POST['id'], 0);
	}
	if ($result) {
		//flash("alert.php");
	}
}

if ($_GET['action'] == "mod") {

	if (!empty($_GET['id'])) {
		$result = $keyword->read(null, $_GET['id']);
		setvar("info",$result);
	}
	$tpl_file = "keyword_edit";
}
$amount = $keyword->findCount();
pageft($amount,$display_eve_page);
$joins = array(
	"Member"=>array("fullTableName"=>$member->getTable(true),"foreignKey"=>"member_id","fields"=>"Member.username as MemberUserName")
	);
$result = $keyword->findAll("member_id,Keyword.id as KeywordId,Keyword.title as KeywordTitle,Keyword.type as KeywordType,Keyword.status as KeywordStatus,Keyword.rank as KeywordRank,clicked as KeywordClicked",$conditions, " Keyword.id desc", $firstcount, $displaypg);
setvar("Lists",$result);
uaAssign(array("Amount"=>$amount,"PageHeader"=>$page_header,"ByPages"=>$pagenav));

template($tpl_file);
?>