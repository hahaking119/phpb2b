<?php
define('CURSCRIPT', 'query');
require("../libraries/common.inc.php");
require(LIB_PATH. "typemodel.inc.php");
uses("product","member","message");
$pms = new Messages();
$member = new Members();
$product = new Products();
if (isset($_POST['id']) && !empty($_POST['do'])) {
	pb_submit_check('inquery');
	$vals['type'] = 'inquery';
	$vals['title'] = $_POST['title'];
	$vals['content'] = implode("<br />", $_POST['inquery']);
	$result = $pms->SendToUser($pb_userinfo['pb_username'], $pdb->GetOne("SELECT username FROM {$tb_prefix}members WHERE id=".intval($_POST['to_member_id'])), $vals);
	if(!$result){
		flash("failed");
	}else{
		flash("success", '', 0);
	}
}
$pid = intval($_GET['id']);
$sql = "SELECT * FROM {$tb_prefix}products WHERE id=".$pid;
$res = $pdb->GetRow($sql);
if (empty($res) || !$res) {
	flash('data_not_exists', 'product/', 0);
}else {
	if (!empty($res['picture'])) {
		$res['imgsmall'] = "attachment/".$res['picture'].".small.jpg";
		$res['imgmiddle'] = "attachment/".$res['picture'].".middle.jpg";
		$res['image'] = "attachment/".$res['picture'];
	}else{
		$res['image'] = "images/nopic.large.jpg";
	}
	setvar("ImTypes", get_cache_type("im_type"));
	setvar("TelTypes", get_cache_type("phone_type"));
	setvar("item",$res);
}

$viewhelper->setTitle($res['name']);
$member_info = $pdb->GetRow("SELECT mf.first_name,mf.last_name,m.email as MemberEmail FROM {$tb_prefix}members m LEFT JOIN {$tb_prefix}memberfields mf ON mf.member_id=m.id WHERE m.id=".$res['member_id']);
formhash();
setvar("CompanyUser",$member_info['first_name'].$member_info['last_name']);
render("product.inquery");
?>