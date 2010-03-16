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
 * @version $Id: content.php 565 2009-12-28 11:21:36Z steven $
 */
define('CURSCRIPT', 'content');
require("../libraries/common.inc.php");
require("../share.inc.php");
include(CACHE_PATH."cache_industry.php");
include(CACHE_PATH."cache_area.php");
uses("product","company","member");
$company = new Companies();
$member = new Members();
$product = new Products();
$tmp_status = explode(",",L('product_status', 'tpl'));
$viewhelper->setPosition(L("product_center", 'tpl'), 'product/');
$viewhelper->setTitle(L("product_center", 'tpl'));
if (isset($_GET['id'])) {
	$id = intval($_GET['id']);
}
$info = $product->getProductById($id);
if(empty($info) || !$info){
	flash("data_not_exists", '', 0);
}
if ($info['state']!=1) {
	flash("unvalid_product", '', 0);
}
if($info['status']!=1){
	$tmp_key = intval($info['status']);
	flash("wait_apply", '', 0);
}
if (!empty($info['member_id'])) {
	$member_info = $member->getInfoById($info['member_id']);
	$info['space_name'] = $member_info['space_name'];
	setvar("MEMBER", $member_info);
}
if (!empty($info['company_id'])) {
	$company_info = $company->getInfoById($info['company_id']);
	$info['companyname'] = $company_info['name'];
	$info['link_people'] = $company_info['link_man'];
	$info['address'] = $company_info['address'];
	$info['zipcode'] = $company_info['zipcode'];
	$info['site_url'] = $company_info['site_url'];
	$info['tel'] = $company_info['tel'];
	$info['fax'] = $company_info['fax'];
	setvar("COMPANY", $company_info);
}
if (!empty($info['industry_id1'])) {
	$viewhelper->setTitle($_PB_CACHE['industry'][1][$info['industry_id1']]);
	$viewhelper->setPosition($_PB_CACHE['industry'][1][$info['industry_id1']], "product/list.php?industryid=".$info['industry_id1']);
}
$viewhelper->setTitle($info['name'], $info['picture']);
setvar("Areas", $_PB_CACHE['area']);
setvar("Industry", $_PB_CACHE['industry']);
$info['title'] = strip_tags($info['name']);
setvar("item", $info);
$product->clicked($id);
render("product.detail");
?>