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
 * @version $Id: common.inc.php 419 2009-12-26 13:35:48Z steven $
 */
if(!defined('IN_PHPB2B')) {
	exit('Access Denied');
}
require("../share.inc.php");
uses("trade","industry","area","tradefield");
require(CACHE_PATH. 'cache_trusttype.php');
require(CACHE_PATH. 'cache_membergroup.php');
$area = new Areas();
$offer = new Tradefields();
$trade = new Trades();
$trade_controller = new Trade();
$industry = new Industries();
$conditions = array();
$industry_id = $area_id = 0;
$conditions[]= "t.status=1";
if (isset($_GET['navid'])) {
	setvar("nav_id", intval($_GET['navid']));
}
?>