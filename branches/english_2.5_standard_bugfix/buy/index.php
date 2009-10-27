<?php
$inc_path = "../";
$li = 1;
require($inc_path."global.php");
require(INC_PATH .'xajax/xajaxAIO.inc.php');
uses("trade","member","product","company","industry","companytype","newstype", "htmlcache");
$htmlcache = new Htmlcaches();
$companytype = new Companytypes();
$industry = new Industries();
$member = new Members();
$product = new Products();
$company = new Companies();
$conditions = null;
$trade = new Trades();
$xajax = new xajax();
$industry_templet = "industry2";
$xajax->configure('javascript URI', URL."app/source/xajax/");
$smarty->register_function("format_amount","splitIndustryAmount");
$xajax->register(XAJAX_FUNCTION, new xajaxUserFunction('getIndustryList', '../ajax.php'));
$xajax->register(XAJAX_FUNCTION,  new xajaxUserFunction('rebuildHTML', '../ajax.php'));
$xajax->processRequest();
setvar('xajax_javascript', $xajax->getJavascript());
$tmp_1 = getdate();
$tmp_today_time = mktime(0,0,0,$tmp_1['mon'],$tmp_1['mday'],$tmp_1['year']);

setvar("Today", $tmp_today_time);
$trade_type = $trade->getTradeTypeKeys("buy");
setvar("AllTradeAmount",$trade->findCount("Trade.type_id in ".$trade_type."","id"));
setvar("TodayTradeAmount",$trade->findCount("Trade.type_id in ".$trade_type." AND created>".$tmp_today_time,"id"));

setvar("IndustryList", $industry->getIndustryPage($li,"buy","industry2"));
if (isset($_GET['action']) && $_GET['action']=="html") {
	$smarty->MakeHtmlFile('../htmls/trade/buy/index.html',$smarty->fetch($theme_name."/buy_index.html"), true, "buy/index.php");
}
template($theme_name."/buy_index");
?>