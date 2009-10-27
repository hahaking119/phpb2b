<?php
$inc_path = "../";
require($inc_path."global.php");
uses("service");
require(SITE_ROOT.'./app/include/page.php');
$service = new Services();
setvar("ServiceTypes",$service->types);
$conditions = null;
$conditions = " Service.status=1";
$page_service = 15;
if ($_POST['s'] && !empty($_POST['service'])) {
	$vals = array();
	$vals['status'] = 0;
	$vals['title'] = $_POST['service']['title'];
	$vals['content'] = $_POST['service']['content'];
	$vals['nick_name'] = $_POST['service']['nick_name'];
	$vals['email'] = $_POST['service']['email'];
	$vals['type_id'] = $_POST['service']['type_id'];
	$vals['created'] = $time_stamp;
	array_walk($vals,"uatrim");
	if($service->save($vals)){
		PB_goto("../message.php?r=1");
	}else {
		PB_goto("../message.php");
	}
}
$amount = $service->findCount($conditions);
pageft($amount,$page_service);
setvar("ServicePageAmount", $tmp_jvar = ($amount==$page_service)?$page_service:($amount%$page_service));
setvar("ServiceList",$service->findAll($service->common_cols,$conditions,"Service.id DESC",$firstcount,$displaypg));
setvar("ByPages",$pagenav);
template($theme_name."/user_service");
?>