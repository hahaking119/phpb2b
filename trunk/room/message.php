<?php
$inc_path = "../";$ua_sm_compile_dir = "room/";
require($inc_path."global.php");
require("session.php");
require(SITE_ROOT.'./app/include/page.php');
uses("companymessage","member","company");
$member = new Members();
$company = new Companies();
$companymessage = new Companymessages();
$conditions = null;
$fields = $companymessage->common_cols;
switch ($_GET['type']) {
	case 'in':
		$conditions_amount = " AND Companymessage.to_member_id = ".$_SESSION['MemberID'];
		$sql = "SELECT ".$fields." FROM ".$companymessage->getTable(true)." LEFT JOIN ".$member->getTable(true)." ON Companymessage.from_member_id=Member.id WHERE Companymessage.to_member_id=".$_SESSION['MemberID']." ORDER BY Companymessage.id DESC";
		break;
	default:
		$conditions_amount = " AND CompanyMessage.from_member_id = ".$_SESSION['MemberID'];
		$sql = "SELECT ".$fields." FROM ".$companymessage->getTable(true)." LEFT JOIN ".$member->getTable(true)." ON Companymessage.to_member_id=Member.id WHERE Companymessage.from_member_id=".$_SESSION['MemberID']." ORDER BY Companymessage.id DESC";
		break;
}

if (isset($_POST['del'])) {
	$result = $companymessage->del($_POST['messageid']," from_member_id=".$_SESSION['MemberID']." or to_member_id=".$_SESSION['MemberID']);
	if ($result) {
		PB_goto("./tip.php?id=1000");
	}else {
		PB_goto("./tip.php?id=1004");
	}
}
$tplname = "message";
if($_GET['action'] == "view" && !empty($_GET['id'])){
	$message_info = $companymessage->read(null, $_GET['id'], null, $conditions_amount);
	if(empty($message_info)){
		PB_goto("./tip.php?id=1004");
	}else{
		setvar("m",$message_info);
		$tplname = "message_detail";
	}
}else{
	$amount = $companymessage->findCount(" 1 ".$conditions_amount);
	pageft($amount);
	$sql.= " LIMIT $firstcount,$displaypg";
	$res = $g_db->GetAll($sql);
	setvar("Messages",$res);
	setvar("ByPages",$pagenav);
}
template($tplname);
?>