<?php
$inc_path = "../";$ua_sm_compile_dir = "room/";
require($inc_path."global.php");
require("session.php");
require(SITE_ROOT.'./app/include/page.php');
uses("inquery","member","company");
$inquery = new Inqueries();
$member = new Members();
$company = new Companies();
$conditions = null;
$tpl_file = "inquery";
$im_types = $member->im_types;
$tel_types = $member->phone_types;
$conditions = " to_member_id=".$_SESSION['MemberID'];
if($_GET['action'] == "view" && !empty($_GET['id'])){
	$result = $inquery->read(null, $_GET['id'], null, " and ".$conditions);
	if(empty($result)){
		flash("./tip.php", null, lgg('data_not_exists'), 0);
	}else{
		$link_info = unserialize($result['InqueryIa']);
		$link_infos = lgg('link_name').":".$link_info['name'];
		$link_infos.= "<br />".lgg('link_tel').":".$tel_types[$link_info['tel_type']].":".$link_info['tel_number'];
		$link_infos.= "<br />".lgg('link_im').":".$im_types[$link_info['im_type']].":".$link_info['im_number'];
		$link_infos.= "<br />Email:".$link_info['email'];
		$result['InqueryLink'] = $link_infos;
		setvar("m",$result);
		$tpl_file = "inquery_detail";
	}
}else{
	$amount = $inquery->findCount($conditions);
	pageft($amount);
	$res = $inquery->findAll("id as InqueryId,title as InqueryProduct,created as CreateDate", $conditions, "id desc", $firstcount, $displaypg);
	setvar("Lists",$res);
	setvar("ByPages",$pagenav);
}
template($tpl_file);
?>