<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './app/configs/db_session.php');
uses("order","member","company","membertype");
require(SITE_ROOT.'./app/include/page.php');
require("session_cp.inc.php");
$membertype = new Membertypes();
$order = new Orders();
$member = new Members();
$company = new Companies();
$conditions = null;
$tpl_file = "order_index";
if (isset($_POST['del']) && !empty($_POST['id'])){
	$deleted = false;
	$result = $order->del($_POST['id']);
	if(!$result)
	{
		flash("./alert.php","./order.php?action=list",null,0);
	}
}
if ($_GET['action']=="del" && !empty($_GET['id'])) {
	$result = $order->del($_GET['id']);
	if ($result) {
		setvar("ActionResult", "已删除");
	}
}
if (isset($_POST['complete']) && !empty($_POST['id'])) {
	$result = $order->check($_POST['id'],1);
	if ($result) {
		flash("./alert.php",null,"订单审核完成");
	}
}
if (isset($_POST['cancel']) && !empty($_POST['id'])){
	$result = $order->check($_POST['id']);
	if ($result) {
		flash("./alert.php",null,"成功取消订单");
	}
}
if($_GET['action'] == "view"){
	$sql = "SELECT Order.* FROM ".$order->getTable(true)." WHERE Order.id=".$_GET['id'];
	$res = $g_db->GetRow($sql);
	if (empty($res)) {
		flash("./alert.php","./order.php", lgg('data_not_exists'),0);
	}else {
		setvar("s",$res);
	}
	$tpl_file = "order_view";
}
if($_GET['action'] = "list"){
	$amount = $order->findCount();
	pageft($amount,$display_eve_page);

	$fields = "Eorder.id,Eorder.member_id,Eorder.product_id,Eorder.year_option,Eorder.created,Eorder.status";
	$joins = array(
	"Member"=>array("fullTableName"=>$member->getTable(true),"foreignKey"=>"member_id","fields"=>"Member.username"),
	"Membertype"=>array("fullTableName"=>$membertype->getTable(true),"foreignKey"=>"product_id","fields"=>"Membertype.name")
	);
	$result = $order->findAll($fields,null," Eorder.id desc",$firstcount,$displaypg);
	setvar("Lists",$result);
	setvar("OrderStatus",$order->order_status);
	setvar("Amount",$amount);
	setvar("PageHeader",$page_header);
	setvar("ByPages",$pagenav);
}


template($tpl_file);
?>