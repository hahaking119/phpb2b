<?php
$inc_path = "../";$ua_sm_compile_dir = "room/";
require($inc_path."global.php");
require("session.php");
uses("trade","product");
require(SITE_ROOT.'./libraries/page.php');
$product = new Products();
$trade = new Trades();
$trade_type_names = $trade->buy_types + $trade->sell_types;
$conditions = "member_id = ".$_SESSION['MemberID'];
$amount = $g_db->GetArray("select Trade.type_id as TradeTypeId,count(Trade.id) as CountTrade from ".$trade->getTable(true)." where ". $conditions. " group by Trade.type_id");
if(is_array($amount))
{
	foreach ($amount as $val) {
		$stats[$val['TradeTypeId']] = array("Amount"=>$val['CountTrade'], "Name"=>$trade_type_names[$val['TradeTypeId']]);
	}
}
setvar("UserTradeStat",$stats);
setvar("ProductAmount",$product->findCount($conditions,"Product.id"));
template("stat");
?>