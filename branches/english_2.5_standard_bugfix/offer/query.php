<?php
require("./sell.php");
require($inc_path."global.php");
uses("trade","industry","member");
$industry = new Industries();
$trade = new Trades();
$member = new Members();
if (isset($_GET['id'])) {
	$sell_id = intval($_GET['id']);
	$sql = "SELECT Trade.id AS TradeId,Trade.topic AS TradeName,Member.id AS MemberId,CONCAT(Member.firstname,Member.lastname) AS MemberName,Member.email AS MemberEmail FROM ".$trade->getTableName()." LEFT JOIN ".$member->getTableName()." ON Trade.member_id=Member.id WHERE Trade.id=".$sell_id;
	$sell_info = $g_db->GetRow($sql);
	setvar("pf",$sell_info);
}
template($theme_name."/trade_query");
?>