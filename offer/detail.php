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
 * @version $Id: detail.php 553 2009-12-28 10:30:05Z steven $
 */
define('CURSCRIPT', 'detail');
require("../libraries/common.inc.php");
require("../share.inc.php");
include(CACHE_PATH. "cache_area.php");
include(CACHE_PATH. "cache_industry.php");
include(CACHE_PATH. "cache_setting1.php");
require(LIB_PATH. "typemodel.inc.php");
$positions = $titles = array();
uses("trade","product","member","company","tradefield","form");
$offer = new Tradefields();
$company = new Companies();
$product = new Products();
$trade = new Trade();
$trade_model = new Trades();
$member = new Members();
$form = new Forms();
setvar("Genders", get_cache_type('gender'));
setvar("PhoneTypes", get_cache_type('phone_type'));
if (isset($_GET['id'])) {
	$id = intval($_GET['id']);
	$trade->setInfoById($id);
	$info = $trade->info;
	if (empty($info)) {
		flash("data_not_exists", '', 0);
	}
	$info['title'].=($_PB_CACHE['setting1']['offer_expire_method']==1 && $info['expdate']<$time_stamp)?"[".L("has_expired", "tpl")."]":'';
	$info['title'].=(!empty($info['if_urgent']))?"[".L("urgent_buy", "tpl")."]":'';
	if ($info['expdate']<$time_stamp && $_PB_CACHE['setting1']['offer_expire_method']==2) {
		flash("has_been_expired", URL, 0, $info['title']);
	}
}else{
	flash("data_not_exists", '', 0);
}
$trade_types = $trade->getTradeTypes();
$viewhelper->setTitle($trade_types[$info['type_id']]);
$viewhelper->setPosition($trade_types[$info['type_id']], "offer/list.php?typeid=".$info['type_id']);
$trade_model->clicked($id);
if ($info['require_point']>0) {
	//check member points
	$point = $trade_model->field("points", "id='".$pb_user['pb_userid']."'");
	if ($point<$info['require_point']) {
		flash("not_enough_points", URL, 0, $info['require_point']);
	}
}
if (isset($info['formattribute_ids'])) {
	$form_vars = $form->getAttributes(explode(",", $info['formattribute_ids']));
	setvar("ObjectParams", $form_vars);
}
$info['pubdate'] = @date("Y-m-d", $info['pubdate']);
$info['expdate'] = @date("Y-m-d", $info['expdate']);
$info['image'] = pb_get_attachmenturl($info['picture']);
$login_check = 1;
if ($info['type_id']==1) {
	$login_check = $_PB_CACHE['setting']['buy_logincheck'];
}elseif ($info['type_id']==2){
	$login_check = $_PB_CACHE['setting']['sell_logincheck'];
}
if (!empty($info['member_id'])) {
	$member_info = $member->getInfoById($info['member_id']);
	$info['link_people'] = $member_info['last_name'];
	$info['space_name'] = $member_info['space_name'];
	$info['tel'] = $member_info['tel'];
	$info['address'] = $member_info['address'];
	$info['zipcode'] = $member_info['zipcode'];
	$info['fax'] = $member_info['fax'];
	$info['site_url'] = $member_info['site_url'];
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
$viewhelper->setMetaDescription($info['content']);
setvar("LoginCheck", $login_check);
$info['title'] = strip_tags($info['title']);
setvar("item",$info);
$viewhelper->setTitle($info['title'], $info['picture']);
setvar("Areas", $_PB_CACHE['area']);
setvar("Industry", $_PB_CACHE['industry']);
setvar("forward", "offer/detail.php?id=".$id);
render("offer.detail");
?>