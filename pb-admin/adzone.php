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
 * @version $Id: adzone.php 458 2009-12-27 03:05:45Z steven $
 */
require("../libraries/common.inc.php");
require("session_cp.inc.php");
uses("adzone");
require(PHPB2B_ROOT.'libraries/page.class.php');
$tpl_file = "adzone";
$adzone = new Adzones();
$page = new Pages();
$conditions = null;
if (isset($_GET['do'])) {
	$do = trim($_GET['do']);
	if (!empty($_GET['id'])) {
		$id = intval($_GET['id']);
		setvar("id", $id);
	}
	if ($do=="del" && !empty($id)) {
		//check if have ad
		$all_ad = $pdb->GetOne("SELECT count(id) FROM {$tb_prefix}adses WHERE adzone_id=".$id);
		if ($all_ad>0) {
			flash("yet_some_ads");
		}else{
			$adzone->del($id);
		}
	}
	if($do == "makejs" && !empty($id)) {
		setvar("XMLDATA",'<{ads typeid='.$id.'}><a href="[link:url]">[field:src]</a><{/ads}>');
		template("adzone.makejs");
		exit;
	}
	if ($do == "edit") {
		if (!empty($id)) {
			$result = $adzone->read("*", $id);
			setvar("item",$result);
		}
		$tpl_file = "adzone.edit";
		template($tpl_file);
		exit;
	}
}
if (isset($_POST['save'])) {
	$vals = $_POST['adzone'];
	$id = $_POST['id'];
	if (empty($vals['what'])) {
		$vals['what'] = 1;
	}
	if (!empty($vals['additional_adwords'])) {
		$vals['additional_adwords'] = stripcslashes($vals['additional_adwords']);
	}
	if (!empty($id)) {
		$vals['modified'] = $time_stamp;
		$result = $adzone->save($vals, "update", $id);
	}else{
		$vals['created'] = $vals['modified'] = $time_stamp;
		$result = $adzone->save($vals);
	}
	if (!$result) {
		flash();
	}
}
if (isset($_POST['del']) && !empty($_POST['id'])) {
	$adzone->del($_POST['id']);
}
$amount = $adzone->findCount();
$page->setPagenav($amount);
$result = $adzone->findAll("*",null, $conditions, " id desc", $page->firstcount, $page->displaypg);
if (!empty($result)) {
	for($i=0; $i<count($result); $i++){
		$result[$i]['numbers'] = $pdb->GetOne("SELECT count(id) AS amount FROM {$tb_prefix}adses WHERE adzone_id=".$result[$i]['id']);
	}
	setvar("Items",$result);
	uaAssign(array("ByPages"=>$page->pagenav));
}
template($tpl_file);
?>