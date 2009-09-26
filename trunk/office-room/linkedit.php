<?php
$inc_path = "../";$ua_sm_compile_dir = "room/";
require($inc_path."global.php");
require("session.php");
uaCheckPermission(2);
uses("member","companylink","company");
$company = new Companies();
$member = new Members();
$companylink = new Companylinks();
$company_id = $company->field("id", "member_id=".$_SESSION['MemberID']);
if ($_GET['action'] == "add" && !empty($_GET['userid'])) {
	$vals = array();
	$vals['CompanyID1']	 = $company_id;
	$member_id2 = $g_db->GetRow("select id,username from ".$member->getTable()." where username='".trim($_GET['userid'])."' and id!=".$_SESSION['MemberID']);
	if(!empty($member_id2)){
		$vals['CompanyID2'] = $company->field("id", "member_id=".intval($member_id2['id']));
		$vals['member_id'] = $_SESSION['MemberID'];
		$vals['user_name'] = $member_id2['username'];
		$vals['created'] =$time_stamp;
		$result = $companylink->save($vals);
		if($result){
			flash("./tip.php", $_SERVER['HTTP_REFERER'], lgg("link_add_ok"));
		}else{
			flash("./tip.php", $_SERVER['HTTP_REFERER'], lgg('repeat_not_allowed'),0);
		}
	}else{
			flash("./tip.php", $_SERVER['HTTP_REFERER'], lgg("link_not_exists"),0);
	}
}else{
	flash("./tip.php", $_SERVER['HTTP_REFERER'], lgg('pls_login_first'),0);
}
$tplname = "link_edit";
$linkid = intval($_POST['id']);
if ($_POST['save']) {
	$vals = array();
	$vals['friendlogo'] = $_POST['companylink']['logo'];
	$result = $companylink->save($vals, "update", $_POST['id'], null, " AND CompanyID1=".$company_id);
	if ($result) {
		PB_goto("./tip.php?id=1000");
	}else {
		PB_goto("./tip.php?id=1004");
	}
}
if (!empty($_GET['id'])) {
	$fields = "Companylink.id AS CompanylinkId,Companylink.CompanyID1 AS MasterID,Companylink.CompanyID2 AS FriendID,Company.name AS FriendName,Companylink.friendlogo AS CompanyFriendlog";
	$sql = "SELECT ".$fields." FROM ".$companylink->getTable(true)." LEFT JOIN ".$company->getTable(true)." ON Companylink.CompanyID2=Company.id WHERE Companylink.CompanyID1=".$company_id." AND Companylink.id=".$_GET['id'];
	$linkinfo = $g_db->GetRow($sql);
	if (empty($linkinfo)) {
		PB_goto("./tip.php?id=1004");
	}
	setvar("LinkInfo",$linkinfo);
}
template($tplname."");
?>