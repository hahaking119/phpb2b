<?php
$inc_path = "../";
$li = 4;
require($inc_path."global.php");
uses("product","member","industry");
$industry = new Industries();
$member = new Members();
$product = new Products();
if ($_POST['id'] && !empty($_POST['query'])) {
	$vals = array();
	$vals = $_POST['query'];

	$vals['contacts'] = serialize($_POST['link']);
	if(isset($_POST['qid'])) $vals['know_more'] = implode(",",$_POST['qid']);
	uses("inquery");
	$inquery = new Inqueries();
	array_walk($vals,"uatrim");
	$vals['created'] = time();
	$vals['contacts'] = serialize($_POST['link']);
	$vals['user_ip'] = uaIp2Long(uaGetClientIP());
	$vals['content'] = $_POST['title'].":".$_POST['content'];
	$vals['title'] = $product->field("name", "id=".intval($_POST['id']));
	$inquery->save($vals);
	PB_goto("../redirect.php", 1, urlencode(lgg("complete")));
}

$pid = intval($_GET['id']);
$sql = "SELECT Product.member_id as MemberId,Product.company_id as CompanyId,Product.id AS ProductId,Product.Name AS ProductName,Member.id AS MemberId,CONCAT(Member.firstname,Member.lastname) AS MemberName,Member.username as MemberUserName,Member.email AS MemberEmail,Industry.id AS IndustryId,Industry.name AS IndustryName FROM ".$product->getTable(true)." LEFT JOIN ".$member->getTable(true)." ON Product.member_id=Member.id LEFT JOIN ".$industry->getTable(true)." ON Product.industry_id=Industry.id WHERE Product.id=".$pid;
$res = $g_db->GetRow($sql);
if (empty($res) || !$res) {
	die(lgg('data_not_exists'));
}else {
	setvar("ImTypes", $member->im_types);
	setvar("TelTypes", $member->phone_types);
	setvar("pf",$res);
}
$member_info = $member->read("firstname,lastname",$res['MemberId']);
setvar("CompanyUser",$member_info['firstname'].$member_info['lastname']);
template($theme_name."/product_query");
?>