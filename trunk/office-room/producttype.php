<?php
$inc_path = "../";$ua_sm_compile_dir = "office-room/";
require($inc_path."global.php");
require("session.php");
uaCheckPermission(2);
uses("product","producttype","company");
$tplname = "product_type";
$company = new Companies();
$product = new Products();
$producttype = new Producttypes();
$conditions = null;
$conditions = "member_id = ".$_SESSION['MemberID'];
$orignal_count = $producttype->findCount($conditions);
$company_id = $company->field("id", "member_id=".$_SESSION['MemberID']);
if ($orignal_count>=10) {
	setvar("AddAble", "disabled");
}
if ($_GET['action']=="del" && !empty($_GET['id'])) {

	$type_id = intval($_GET['id']);
	$conditions2 = "producttype_id=".$type_id." and member_id=".$_SESSION['MemberID'];
	$product_amount = $product->findCount($conditions2);
	if ($product_amount>0) {
		flash("./tip.php", "./producttype.php", lgg('pls_del_first'), 0);
	}else{
		$conditions3 = array("member_id=".$_SESSION['MemberID']);
		$result = $producttype->del($type_id, $conditions3);
	}
}
if($_POST['update_level']){
	die("Update successfully");
}
if (isset($_POST['save']) && !empty($_POST['type_name'])) {
	if ($orignal_count>=10) {
		$msg = sprintf(lgg("one_day_max"), 10);
		die($msg);
	}
	$record = array();
	$record['name'] = $_POST['type_name'];
	array_walk($record,"uatrim");
	if($_POST['id']){
		$result = $producttype->save($record, "update", $_POST['id'], null, " and ".$conditions);
	}else{
		$record['member_id'] = $_SESSION['MemberID'];
		$record['created'] = $time_stamp;
		$record['company_id'] = $company_id;
		$result = $producttype->save($record);
	}
	if(!$result){
		flash("./tip.php","./producttype.php",lgg('not_defined_error'),0);
	}else{
		flash("./tip.php");
	}
}
if (isset($_GET['id']) && $_GET['action']=="mod") {
	$res = $producttype->read($producttype->common_cols,intval($_GET['id']),null," and ".$conditions);
	setvar("ProdTypeRes",$res);
	$tplname = "product_type_action";
}else {
	$typeres = $producttype->findAll($producttype->common_cols,$conditions," id DESC",0,10);
	setvar("ProductTypes",$typeres);
}

template($tplname);
?>