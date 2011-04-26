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
 * @version $Id: index.php 432 2009-12-26 13:46:49Z steven $
 */
define('CURSCRIPT', 'index');
require("../libraries/common.inc.php");
require("../offer/common.inc.php");
setvar("nav_id", 3);
require(PHPB2B_ROOT.'libraries/page.class.php');
$page = new Pages();
$page->pagetpl_dir = $theme_name;
$viewhelper->setTitle(L('seller', 'tpl'));
$viewhelper->setPosition(L('seller', 'tpl'));
$conditions[]= "t.type_id='2'";
if (isset($_GET['industryid'])) {
	$industry_id = intval($_GET['industryid']);
	$tmp_info = $industry->setInfo($industry_id);
	if (!empty($tmp_info)) {
		$conditions[] = "t.industry_id".$tmp_info['level']."=".$tmp_info['id'];
		$viewhelper->setTitle($tmp_info['name']);
		$viewhelper->setPosition($tmp_info['name'], "offer/list.php?industryid=".$tmp_info['id']);
	}
}
setvar("OtherIndustry", $industry->getSubIndustry($industry_id, true));
if (isset($_GET['areaid'])) {
	$area_id = intval($_GET['areaid']);
	$tmp_info = $area->setInfo($area_id);
	if (!empty($tmp_info)) {
		$conditions[] = "t.area_id".$tmp_info['level']."=".$tmp_info['id'];
		$viewhelper->setTitle($tmp_info['name']);
		$viewhelper->setPosition($tmp_info['name'], "offer/list.php?areaid=".$tmp_info['id']);
	}
}
setvar("OtherArea", $area->getSubArea($area_id, true));
if (isset($_GET['type'])) {
	if($_GET['type']=="urgent"){
		$conditions[]="t.if_urgent='1'";
	}
}
$trade->setCondition($conditions);
$amount = $trade->findCount(null, $conditions, null, "t");
$page->setPagenav($amount);
$sql = "SELECT m.space_name as userid,m.membertype_id,m.username,m.trusttype_ids,m.credits,m.membergroup_id,t.member_id,t.industry_id1,t.industry_id2,t.industry_id3,t.area_id1,t.area_id2,t.area_id3,t.id,t.type_id,t.company_id,t.title,t.content,t.submit_time,t.picture,t.expire_time,t.status,t.require_point,t.require_membertype,t.cache_companyname as companyname FROM {$tb_prefix}trades t LEFT JOIN {$tb_prefix}members m ON m.id=t.member_id ".$trade->getCondition()." ORDER BY t.id DESC LIMIT ".$page->firstcount.",".$page->displaypg;
$result = $pdb->GetArray($sql);
$result = $trade->formatResult($result);
setvar('Items', $result);
uaAssign(array("ByPages"=>$page->getPagenav(), "Industries"=>$industry->getIndustry(), "Areas"=>$area->getCacheArea()));
setvar("TradeTypes", $trade_controller->getTradeTypes());
setvar("typeid", 2);
render("offer.list");
?>