<?php
$inc_path = "../";
$li = 2;
require($inc_path."global.php");
require(SOURCE_PATH .'xajax/xajaxAIO.inc.php');
uses("trade", "htmlcache","industry");
$industry_templet = "industry2";
$htmlcache = new Htmlcaches();
$industry = new Industries();
$trade = new Trades();
$xajax = new xajax();
$smarty->register_function("format_amount","splitIndustryAmount");
$xajax->configure('javascript URI', URL."libraries/source/xajax/");
$xajax->register(XAJAX_FUNCTION, new xajaxUserFunction('getIndustryList', '../ajax.php'));
$xajax->processRequest();
setvar('xajax_javascript', $xajax->getJavascript());
$tables = $trade->getTable(true);
$tmp_today_time = mktime(0,0,0,date("m") ,date("d"),date("Y"));
setvar("Today", $tmp_today_time);
$trade_type = $trade->getTradeTypeKeys("sell");
setvar("AllTradeAmount", intval($trade->findCount("Trade.type_id in ".$trade_type."","id")));
setvar("TodayTradeAmount", intval($trade->findCount("Trade.type_id in ".$trade_type." and submit_time>".$tmp_today_time,"id")));

setvar("IndustryList", $industry->getIndustryPage(2,"sell","industry2"));
template($theme_name."/sell_index");
?>