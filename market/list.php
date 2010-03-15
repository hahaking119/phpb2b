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
define('CURSCRIPT', 'list');
require("../libraries/common.inc.php");
require("../share.inc.php");
uses("area","market","industry");
require(PHPB2B_ROOT.'./libraries/page.class.php');
require(CACHE_PATH. "cache_area.php");
$area = new Areas();
$page = new Pages();
$page->pagetpl_dir = $theme_name;
$market = new Markets();
$industry = new Industries();
$conditions = array();
$viewhelper->setTitle(L("market", "tpl"));
$viewhelper->setPosition(L("market", "tpl"), "market/");
if (isset($_GET['industryid'])) {
	$industry_id = intval($_GET['industryid']);
	$tmp_info = $industry->setInfo($industry_id);
	if (!empty($tmp_info)) {
		$conditions[] = "t.industry_id".$tmp_info['level']."=".$tmp_info['id'];
		$viewhelper->setTitle($tmp_info['name']);
		$viewhelper->setPosition($tmp_info['name'], "market/list.php?industryid=".$tmp_info['id']);
	}
}
if (isset($_GET['areaid'])) {
	$area_id = intval($_GET['areaid']);
	$tmp_info = $area->setInfo($area_id);
	if (!empty($tmp_info)) {
		$conditions[] = "area_id".$tmp_info['level']."=".$tmp_info['id'];
		$viewhelper->setTitle($tmp_info['name']);
		$viewhelper->setPosition($tmp_info['name'], "market/list.php?areaid=".$tmp_info['id']);
	}
}
setvar("OtherArea", $area->getSubArea($area_id, true));
$conditions[] = "Market.status=1";
if (isset($_GET['do'])) {
	if($_GET['do'] == "search"){
		$s_key = $_GET['q'];
		if($s_key) {
			$conditions[] = "Market.name like '%".$s_key."%'";
		}
	}
}
$viewhelper->setTitle(L("search", "tpl"));
$viewhelper->setPosition(L("search", "tpl"));
$amount = intval($market->findCount(null, $conditions));
$page->setPagenav($amount);
$result = $market->findAll("*", null, $conditions, "Market.id DESC", $page->firstcount, $page->displaypg);
if (!empty($result)) {
	for($i=0; $i<count($result); $i++){
		if(!empty($result[$i]['picture'])) $result[$i]['image'] = pb_get_attachmenturl($result[$i]['picture']);
	}
}
setvar("SearchAmount", L("search_amount", "tpl"));
setvar("Items", $result);
setvar("AreaItems", $_PB_CACHE['area']);
setvar("Amount", $amount);
setvar("ByPages",$page->pagenav);
render("market.list");
?>