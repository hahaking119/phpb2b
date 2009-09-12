<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './app/configs/db_session.php');
uses("stat", "trade", "company", "product", "member");
require("session_cp.inc.php");
$stat = new Stats();
$company = new Companies();
$product = new Products();
$member = new Members();
$trade = new Trades();
$today_mktime = mktime(0,0,0,date("m") ,date("d"),date("Y"));
$conditions = null;
$fields = "description as StatDescription,sc as StatAmount,sb as StatTitle";
$lists = $stat->findAll($fields, $conditions, "id desc", 0, 25);
if(isset($_GET['action'])){
	if($_GET['action']=="update"){
		$buy = $trade->findCount("type_id in ".$trade->getTradeTypeKeys("buy"), "id");
		$buy_today = $trade->findCount("type_id in ".$trade->getTradeTypeKeys("buy")." and submit_time>".$today_mktime, "id");
		$sell = $trade->findCount("type_id in ".$trade->getTradeTypeKeys("sell"), "id");
		$sell_today = $trade->findCount("type_id in ".$trade->getTradeTypeKeys("sell")." and submit_time>".$today_mktime, "id");
		$product_m = $product->findCount(null, "id");
		$product_today = $product->findCount("created>".$today_mktime, "id");
		$company_m = $company->findCount(null, "id");
		$company_today = $company->findCount("created>".$today_mktime, "id");
		$member_m = $member->findCount(null, "id");
		$member_today = $member->findCount("created>".$today_mktime, "id");
		
		$stat->saveField("sc", $buy, null, "sb='buy'");
		$stat->saveField("sc", $buy_today, null, "sb='buy_today'");
		$stat->saveField("sc", $sell, null, "sb='sell'");
		$stat->saveField("sc", $sell_today, null, "sb='sell_today'");
		$stat->saveField("sc", $product_m, null, "sb='product'");
		$stat->saveField("sc", $product_today, null, "sb='product_today'");
		$stat->saveField("sc", $company_m, null, "sb='company'");
		$stat->saveField("sc", $company_today, null, "sb='company_today'");
		$stat->saveField("sc", $member_m, null, "sb='member'");
		$result = $stat->saveField("sc", $member_today, null, "sb='member_today'");
		if($result){
			flash("alert.php", "stat.php");
		}
	}
}
setvar("Lists", $lists);
template("stat_index");
?>