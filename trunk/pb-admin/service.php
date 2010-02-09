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
 * @version $Id: service.php 427 2009-12-26 13:45:47Z steven $
 */
require("../libraries/common.inc.php");
uses("service");
require(PHPB2B_ROOT.'./libraries/page.class.php');
require("session_cp.inc.php");
require(LIB_PATH. "typemodel.inc.php");
$page = new Pages();
$service = new Services();
$conditions = null;
$tpl_file = "service";
setvar("Status", get_cache_type("common_status"));
setvar("ServiceTypes", get_cache_type("service_type"));
if (isset($_GET['do'])) {
	$do = trim($_GET['do']);
	if (!empty($_GET['id'])) {
		$id = intval($_GET['id']);
	}
	if ($do == "edit" && !empty($id)) {
		$sql = "SELECT * FROM {$tb_prefix}services WHERE id=".$id;
		$res = $pdb->GetRow($sql);
		if (empty($res)) {
			flash();
		}else {
			setvar("item",$res);
		}
		$tpl_file = "service.edit";
		template($tpl_file);
		exit;
	}
	if ($do == "search") {
		if (!empty($_GET['type_id'])) {
			$conditions[] = "Service.type_id=".$_GET['type_id'];
		}
		if (!empty($_GET['q'])) {
			$conditions[] = "Service.title like '%".$_GET['q']."%' OR Service.content like '%".$_GET['q']."%'";
		}
	}
}
if (isset($_POST['save']) && !empty($_POST['data']['service'])) {
	$vals = array();
	$vals = $_POST['data']['service'];
	$service->save($vals, "update", $_POST['id']);
}
$amount = $service->findCount(null, $conditions,"Service.id");
$page->setPagenav($amount);
setvar("Items",$service->findAll("*", null, $conditions, "Service.id DESC ",$page->firstcount,$page->displaypg));
setvar("ByPages",$page->pagenav);
if (isset($_REQUEST['del'])){
	$deleted = false;
	if(!empty($_POST['id'])) {
		$deleted = $service->del($_POST['id']);
	}
	if(!empty($_GET['id'])){
		$deleted = $service->del($_GET['id']);
	}
	if($deleted) {
		pheader("location:service.php");
	}
	else
	{
		flash();
	}
}
template($tpl_file);
?>