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
 * @version $Id: index.php 459 2009-12-27 03:07:23Z steven $
 */
define('CURSCRIPT', 'area');
require("../libraries/common.inc.php");
require("../share.inc.php");
uses("area");
$area = new Areas();
$viewhelper->setPosition(L("sub_special", "tpl"), "special/");
$viewhelper->setTitle(L("sub_special", "tpl"));
$viewhelper->setPosition(L("sub_area", "tpl"), "special/index.php?type=area");
$viewhelper->setTitle(L("sub_area", "tpl"));
if (isset($_GET['id']) || isset($_GET['name'])) {
	if (!empty($_GET['id'])) {
		$area_id = intval($_GET['id']);
	}elseif (!empty($_GET['name']) && $rewrite_able){
		$name = trim(rawurldecode($_GET['name']));
		if (is_numeric($name)) {
			$area_id = intval($name);
		}else{
			$area_id = $area->field("id", "name='".$name."'");
		}
	}
	$product_amount = $pdb->GetOne("SELECT count(id) FROM ".$tb_prefix."products WHERE area_id1={$area_id} OR area_id2={$area_id} OR area_id3={$area_id}");
	if ($product_amount>0) {
		setvar("HaveProducts", true);
	}
	$area->setInfo($area_id);
	if (!empty($area->info)) {
		$cache_id = $area_id;
		$viewhelper->setTitle($area->info['name']);
		if (empty($area->info['description'])) {
			$area->info['description'] = nl2br(sprintf(L("sub_default_desc", "tpl"), $area->info['name'], L("sub_area", "tpl")));
		}
		$viewhelper->setMetaDescription($area->info['description']);
		$viewhelper->setMetaKeyword(implode(",", array($area->info['name'].L("offer", "tpl"), $area->info['name'].L("market", "tpl"), $area->info['name'].L("product_center", "tpl"), $area->info['name'].L("yellow_page", "tpl"), $area->info['name'].L("info", "tpl"))));
		setvar("item", $area->info);
	}else{
		flash("data_not_exists", URL);
	}
	render("special.area");
}else{
	flash("data_not_exists", URL);
}
?>