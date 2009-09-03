<?php
$inc_path = "../";$ua_sm_compile_dir = "room/";
require($inc_path."global.php");require("session.php");
uses("product","producttype","member","access");
require(SITE_ROOT.'./app/include/page.php');
$tpl_file = "product_list";
$action_level = 2;
uaCheckPermission($action_level);
$access = new Accesses();
$product = new Products();
$producttype = new Producttypes();
$conditions = null;
$table = $product->getTable(true);
$conditions = "member_id = ".$_SESSION['MemberID'];
if ($_GET['action'] == "state") {
	switch ($_GET['type']) {
		case "up":
			$state = 1;
			break;
		case "down":
			$state = 0;
			break;
		default:
			$state = 0;
			break;
	}
	if ($_GET['id']) {
		$vals['state'] = $state;
		$updated = $product->save($vals, "update", $_GET['id'], null, " and ".$conditions);
		if ($updated) {
			$msg = lgg('action_complete');
		}else{
			$msg = lgg('not_defined_error');
		}
	}else{
		$msg = lgg('not_defined_error');
	}
}
setvar("ProductTypes",$producttype->findAll($producttype->common_cols, $conditions, " id desc",0,10));
if ($_GET['act'] == "del" && !empty($_GET['id'])) {
	$res = $product->read("id",$_GET['id']);
	if($res){
		if($product->del($_GET['id'], "member_id=".$_SESSION['MemberID'])){
			$msg = lgg('action_complete');
		}
	}else {
		$msg = lgg('no_data_deleted');
	}
}
if (!empty($_GET['sid'])) {
	$conditions = "Product.producttype_id = ".$_GET['sid']." and Product.member_id = ".$_SESSION['MemberID'];
}else {
	$conditions = "Product.member_id = ".$_SESSION['MemberID'];
}
$sql = "select status AS ProductStatus,count(id) AS ProductAmount from ".$product->getTable()." where member_id = ".$_SESSION['MemberID']." group by status";
$res = $g_db->GetArray($sql);
foreach ($res as $key=>$val) {
	$a[$val['ProductStatus']] = $val['ProductAmount'];
}

if (!empty($a)) {
	$amount = array_sum($a);
}else{
	$amount = $product->findCount($conditions,"Product.id");
}
$a['max'] = $access->field("max_product","membertype_id=".$ua_user['user_type']);
if ($a['max']==0) {
	$a['max'] = lgg('no_limit');
	$remain = lgg('no_limit');
}else{
	$remain = $a['max']-$amount;
}
setvar("CountProduct",$a);
pageft($amount,12);
setvar("ProductList",$product->findAll($product->common_cols,$conditions,"Product.id DESC",$firstcount,$displaypg));
setvar("CheckStatus", explode(",",lgg('product_status')));
uaAssign(array("Amount"=>$amount,"ByPages"=>$pagenav,"Msg"=>$msg,"Remain"=>($remain)));
setvar("ProductSorts",explode(",",lgg('product_sorts')));
template($office_theme_name."/".$tpl_file);
?>