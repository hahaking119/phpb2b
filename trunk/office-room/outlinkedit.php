<?php
$inc_path = "../";$ua_sm_compile_dir = "room/";
require($inc_path."global.php");
require("session.php");
uaCheckPermission(2);
uses("member","companyoutlink","company");
$company = new Companies();
$companyoutlink = new Companyoutlinks();
$tplname = "outlink_edit";
$linkid = intval($_POST['id']);
$company_id = $company->field("id", "member_id=".$_SESSION['MemberID']);
$conditions = " AND member_id=".$_SESSION['MemberID'];
if ($_POST['save']) {
	$vals = array();
	$vals['url'] = $_POST['companyoutlink']['url'];
	$vals['name'] = $_POST['companyoutlink']['name'];
	array_walk($vals, "uatrim");
	if($linkid){
		$result = $companyoutlink->save($vals, "update", $linkid, null, $conditions);
	}else{
		$vals['member_id'] = $_SESSION['MemberID'];
		$vals['company_id'] = $company_id;
		$vals['created'] = $time_stamp;
		$now_link_amount = $companyoutlink->findCount($conditions);
		if ($ua_user['user_type'] == 1 && $now_link_amount>=3) {
			PB_goto("./tip.php?id=1013");
		}
		$result = $companyoutlink->save($vals);
	}
	if ($result) {
		PB_goto("./tip.php?id=1000");
	}else {
		PB_goto("./tip.php?id=1004");
	}
}
if (!empty($_GET['id'])) {
	$linkinfo = $companyoutlink->read(null, $_GET['id'], null, $conditions);
	if (empty($linkinfo)) {
		PB_goto("./tip.php?id=1004");
	}
	setvar("LinkInfo",$linkinfo);
}
template($tplname."");
?>