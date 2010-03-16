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
 * @version $Id: stat.php 428 2009-12-26 13:45:57Z steven $
 */
require("../libraries/common.inc.php");
require("room.share.php");
uses("trade","product");
check_permission("offer");
$product = new Products();
$trade = new Trades();
$trade_controller = new Trade();
$trade_type_names = $trade_controller->getTradeTypes();
$conditions = "member_id = ".$_SESSION['MemberID'];
$amount = $pdb->GetArray("select Trade.type_id as TradeTypeId,count(Trade.id) as CountTrade from ".$trade->getTable(true)." where ". $conditions. " group by Trade.type_id");
if(is_array($amount))
{
	$stats = array();
	foreach ($amount as $val) {
		$stats[$val['TradeTypeId']] = array("Amount"=>$val['CountTrade'], "name"=>$trade_type_names[$val['TradeTypeId']]);
	}
}
setvar("UserTradeStat",$stats);
setvar("ProductAmount",$product->findCount(null, $conditions,"Product.id"));
template("stat");
?>