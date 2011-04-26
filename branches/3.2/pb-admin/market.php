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
 * @version $Id: market.php 559 2009-12-28 11:11:11Z steven $
 */
require("../libraries/common.inc.php");
uses("market", "attachment");
require(LIB_PATH. 'page.class.php');
require("session_cp.inc.php");
require(CACHE_PATH. "cache_industry.php");
require(CACHE_PATH. "cache_area.php");
require(LIB_PATH. "typemodel.inc.php");
$attachment = new Attachment('pic');
$market = new Markets();
$page = new Pages();
$conditions = null;
$tpl_file = "market";
if (isset($_POST['del']) && !empty($_POST['id'])) {
	$market->del($_POST['id']);
}
if (isset($_POST['check']) && !empty($_POST['id'])) {
	$ids = implode(",", $_POST['id']);
	$condition = " id in (".$ids.")";
	$sql = "update {$tb_prefix}markets set status=1 where ".$condition;
	$result = $pdb->Execute($sql);
}
if (isset($_POST['uncheck']) && !empty($_POST['id'])) {
	$ids = implode(",", $_POST['id']);
	$condition = " id IN (".$ids.")";
	$sql = "UPDATE {$tb_prefix}markets SET status=0 WHERE ".$condition;
	$result = $pdb->Execute($sql);
}
if (isset($_POST['save']) && !empty($_POST['data']['market'])) {
	$vals = array();
	$vals = $_POST['data']['market'];
	if (!empty($_FILES['pic']['name'])) {
		$attachment->rename_file = $time_stamp;
		$attachment->upload_process();
		$vals['picture'] = $attachment->file_full_url;
	}
	$id = intval($_POST['id']);
	if (!empty($id)) {
		$vals['modified'] = $time_stamp;
		$result = $market->save($vals, "update", $id);
	}else {
		$vals['created'] = $vals['modified'] = $time_stamp;
		$result = $market->save($vals);
	}
	if(!$result){
		flash();
	}
}
if (isset($_GET['do'])) {
	$do = trim($_GET['do']);
	$res = null;
	if(!empty($_GET['id'])) {
		$id = intval($_GET['id']);
	}
	if ($do == "edit") {
		if(!empty($id)){
			$sql = "select * FROM {$tb_prefix}markets WHERE id=".$id;
			setvar("item", $pdb->GetRow($sql));
		}
		setvar("MarketStatus", get_cache_type("common_status"));
		setvar("ParentIndustryOptions", $res);
		$tpl_file = "market.edit";
		template($tpl_file);
		exit;
	}
	if ($do == "del" && !empty($id)) {
		$market->del($id);
	}
}
$amount = $market->findCount();
$page->setPagenav($amount);
$result = $market->findAll("*", null, $conditions, "id desc", $page->firstcount, $page->displaypg);
if (!empty($result)) {
	$count = count($result);
	for($i=0; $i<$count; $i++) {
		$result[$i]['industryname'] = $_PB_CACHE['industry'][1][$result[$i]['industry_id1']].$_PB_CACHE['industry'][2][$result[$i]['industry_id2']];
		$result[$i]['areaname'] = $_PB_CACHE['area'][1][$result[$i]['area_id1']].$_PB_CACHE['area'][2][$result[$i]['area_id2']];
	}
	setvar("Items", $result);
	setvar("ByPages", $page->pagenav);
}
template($tpl_file);
?>