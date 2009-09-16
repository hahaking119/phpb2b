<?php
uses("trade", "htmlcache","industry");
$industry_templet = "industry2";
$htmlcache = new Htmlcaches();
$industry = new Industries();
$trade = new Trades();
$smarty->register_function("format_amount","splitIndustryAmount");
$tables = $trade->getTable(true);
$tmp_today_time = mktime(0,0,0,date("m") ,date("d"),date("Y"));
setvar("Today", $tmp_today_time);
$trade_type = $trade->getTradeTypeKeys("sell");
setvar("AllTradeAmount", intval($trade->findCount("Trade.type_id in ".$trade_type."","id")));
setvar("TodayTradeAmount", intval($trade->findCount("Trade.type_id in ".$trade_type." and submit_time>".$tmp_today_time,"id")));
setvar("IndustryList", $industry->getIndustryPage(2,"sell","industry2"));
?>