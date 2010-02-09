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
require("common.inc.php");
require(PHPB2B_ROOT.'libraries/page.class.php');
include(CACHE_PATH. "cache_setting1.php");
$page = new Pages();
$page->pagetpl_dir = $theme_name;
$viewhelper->setTitle(L('offer', 'tpl'));
$viewhelper->setPosition(L('offer', 'tpl'), "offer/");
if (isset($_GET['typeid'])) {
	$type_id = intval($_GET['typeid']);
	$conditions[]= "t.type_id='".$type_id."'";
	setvar("typeid", $type_id);
	$trade_controller->setTypeInfo($type_id);
	$type_name = $trade_controller->type_info['name'];
	$viewhelper->setTitle($type_name);
	$viewhelper->setPosition($type_name, "offer/list.php?typeid=".$type_id);
}
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
if (isset($_GET['do'])) {
	$do = trim($_GET['do']);
	if ($do == "search") {
		if (isset($_GET['q'])) {
			$searchkeywords = urldecode($_GET['q']);
			$conditions[]= "t.title like '%".$searchkeywords."%'";
		}
	}
		if (isset($_GET['pubdate'])) {
			switch ($_GET['pubdate']) {
				case "l3":
					$conditions[] = "t.submit_time>".($time_stamp-3*86400);
					break;
				case "l10":
					$conditions[] = "t.submit_time>".($time_stamp-10*86400);
					break;
				case "l30":
					$conditions[] = "t.submit_time>".($time_stamp-30*86400);
					break;
				default:
					break;
			}
		}
}
if ($_PB_CACHE['setting1']['offer_expire_method']==2 || $_PB_CACHE['setting1']['offer_expire_method']==3) {
	$conditions[] = "t.expire_time>".$time_stamp;
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
render("offer.list");
?>