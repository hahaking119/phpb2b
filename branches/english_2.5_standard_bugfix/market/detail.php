<?php
$inc_path = "../";
$li = 6;
require($inc_path."global.php");
uses("market","trade","industry", "area", "news");
$news = new Newses();
$trade = new Trades();
$area = new Areas();
$industry = new Industries();
$market = new Markets();
setvar("TradeTypes", $trade->getTradeTypes());
$market_id = intval($_GET['id']);

$sql = "select Market.id as MarketId,picture as MarketPicture,Market.status as MarketStatus,Market.content as MarketContent,Market.industry_id,Market.province_id,Market.city_id,Market.country_id,Market.name as MarketName from ".$tb_prefix."markets Market where Market.status=1 and Market.id='".$market_id."'";
$MarketInfo = $g_db->GetRow($sql);
$fields = "Trade.id AS TradeId,Trade.topic AS TradeTopic,html_file_id AS HtmlFileId,type_id as TradeTypeId";
$conditions = " Trade.status='1'";
$res = $trade->findAll($fields, $conditions, "Trade.id desc", 0, 12);
setvar("LatestTrades",$res);
if (intval($MarketInfo['MarketStatus'])==0) {
	$MarketInfo['MarketName'] = null;
	$MarketInfo['MarketContent'] = lgg('market_checking');
}

setvar("i",$MarketInfo);
include("industry.php");
template($theme_name."/market_view");
?>