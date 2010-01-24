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
 * @version $Id: list.php 458 2009-12-27 03:05:45Z steven $
 */
//$li = 7;
define('CURSCRIPT', 'list');
require("../libraries/common.inc.php");
require(PHPB2B_ROOT.'./libraries/page.class.php');
require(CACHE_PATH. "cache_expotype.php");
include(CACHE_PATH. "cache_industry.php");
include(CACHE_PATH. "cache_area.php");
uses("expo","area");
$expo = new Expoes();
$page = new Pages();
$area = new Areas();
$conditions = array();
if (isset($_GET['do'])) {
	$do = trim($_GET['do']);
	if ($do == "search") {
		if (!empty($_GET['q'])) {
			$conditions[] = "name like '%".$_GET['q']."%'";
		}
	}
}
if (isset($_GET['type'])) {
	if ($_GET['type']=="commend") {
		$conditions[] = "if_commend=1";
	}
}
if(isset($_GET['typeid'])){
	$type_id = intval($_GET['typeid']);
	$conditions[] = "expotype_id=".$type_id;
	$type_name = $_PB_CACHE['expotype'][$type_id];
	$viewhelper->setTitle($type_name);
	$viewhelper->setPosition($type_name, "fair/list.php?typeid=".$type_id);
}
if (isset($_GET['areaid'])) {
	$area_id = intval($_GET['areaid']);
	$tmp_info = $area->setInfo($area_id);
	if (!empty($tmp_info)) {
		$conditions[] = "area_id".$tmp_info['level']."=".$tmp_info['id'];
		$viewhelper->setTitle($tmp_info['name']);
		$viewhelper->setPosition($tmp_info['name'], "fair/list.php?areaid=".$tmp_info['id']);
	}
}
$amount = $expo->findCount(null, $conditions);
$page->setPagenav($amount);
$result = $expo->findAll("*", null, $conditions, "id desc", $page->firstcount, $page->displaypg);
setvar("Items", $result);
setvar("Areas", $_PB_CACHE['area']);
setvar("Type",$_PB_CACHE['expotype']);
$viewhelper->setTitle(L("search", "tpl"));
$viewhelper->setPosition(L("search", "tpl"));
render("fair.list");
?>