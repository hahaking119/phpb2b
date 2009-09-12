<?php
if(!defined('IN_UALINK')) exit('Access Denied');
require(SITE_ROOT.'./app/include/page.php');
uses("trade", "offer");
$trade = new Trades();
$offer = new Offers();
$conditions = null;
$conditions.= " Trade.status=1 and Trade.member_id=".$companyinfo['member_id'];
pageft($trade->findCount($conditions,"Trade.id"), 10);
$join = null;
$company_offers = $trade->findAll("type_id as TradeTypeId,id as TradeId,topic as TradeTopic,content as TradeContent,created as CreateDate,picture as TradePicture", $conditions,"Trade.id desc",$firstcount,$displaypg);
setvar("TradeTypes", $trade->getTradeTypes());
setvar("TradeNames", $trade->getTradeTypeNames());
setvar("Offers",$company_offers);
setvar("ByPages",$pagenav);
template("../skins/".$tplpath."offer");
?>