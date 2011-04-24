<?php
/**
 * NOTE   :  PHP versions 4 and 5
 *
 * PHPB2B :  An Opensource Business To Business E-Commerce Script (http://www.phpb2b.com/)
 * Copyright 2007-2009, Ualink E-Commerce Co,. Ltd.
 *
 * Licensed under The GPL License (http://www.opensource.org/licenses/gpl-license.php)
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * @copyright Copyright 2007-2009, Ualink E-Commerce Co,. Ltd. (http://phpb2b.com)
 * @since PHPB2B v 1.0.0
 * @link http://phpb2b.com
 * @package phpb2b
 * @version $Id: offer.php 481 2009-12-28 01:05:06Z steven $
 */
if(!defined('IN_PHPB2B')) exit('Not A Valid Entry Point');
require(PHPB2B_ROOT.'libraries/page.class.php');
uses("trade", "tradefield");
$trade = new Trades();
$trade_controller = new Trade();
$tradefiled = new Tradefields();
$page = new Pages();
$page->displaypg = 20;
$page->is_rewrite = true;
$page->_url = $space->rewriteList("offer");
$conditions = array();
$conditions[]= "Trade.status=1 and Trade.member_id='".$member->info['id']."'";
$amount = $trade->findCount(null, $conditions,"Trade.id");
$page->setPagenav($amount);
$join = null;
$company_offers = $trade->findAll("type_id as typeid,id as offerid,id,title,title as topic,content,created,picture",null,  $conditions,"id desc",$page->firstcount,$page->displaypg);
setvar("TradeTypes", $tradetypes = $trade_controller->getTradeTypes());
setvar("TradeNames", $tradenames = $trade_controller->getTradeTypeNames());
if (!empty($company_offers)) {
	for ($i=0; $i<count($company_offers); $i++){
		$company_offers[$i]['typename'] = $tradetypes[$company_offers[$i]['typeid']];
		$company_offers[$i]['pubdate'] = date("Y-m-d", $company_offers[$i]['created']);
		$company_offers[$i]['image'] = URL. pb_get_attachmenturl($company_offers[$i]['picture'], '', 'small');
		$company_offers[$i]['url'] = $space->rewriteDetail("offer", $company_offers[$i]['id']);
	}
}
setvar("Items",$company_offers);
setvar("ByPages",$page->pagenav);
$space->render("offer");
?>