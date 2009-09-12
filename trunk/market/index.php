<?php
$inc_path = "../";
$li = 6;
require($inc_path."global.php");
require(INC_PATH .'xajax/xajaxAIO.inc.php');
uses("market","trade","industry","product","news","htmlcache");
$htmlcache = new Htmlcaches();
$market = new Markets();
$news = new Newses();
$product = new Products();
$trade = new Trades();
$industry = new Industries();

$xajax = new xajax();
$xajax->configure('javascript URI', URL."app/source/xajax/");
$xajax->register(XAJAX_FUNCTION,  new xajaxUserFunction('rebuildHTML', '../ajax.php'));
$xajax->processRequest();
setvar('xajax_javascript', $xajax->getJavascript());
setvar("TradeTypes", $trade->getTradeTypes());
setvar("TradeNames", $trade->getTradeTypeNames());
$fields = null;
$table = null;
$fields = "id as MarketId,name as MarketName";
$table['market'] = $market->getTable(true);
$latest_markets = $market->findAll($fields, null,"id desc",0,16);
setvar("LatestMarkets",$latest_markets);
setvar("MarketAmount",$market->findCount());

$fields = "id as IndustryId,name as IndustryName";
$conditions = " Industry.if_setby_market=1";
$industry_res = $industry->findAll($fields, $conditions, "id desc", 0, 30);
$fields = "id as ProductId,name as ProductName,html_file_id as HtmlFileId,picture as ProductPicture";
$conditions = " status=1";
$product_res = $product->findAll($fields, $conditions, "id desc", 0, 2);
setvar("LatestProduct",$product_res);

include("./industry.php");
if (isset($_GET['action']) && $_GET['action']=="html") {
	$smarty->MakeHtmlFile('../htmls/market/index.html',$smarty->fetch($theme_name."/market_index.html"), true, "market/index.php");
}
template($theme_name."/market_index");
?>