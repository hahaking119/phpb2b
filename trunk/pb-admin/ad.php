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
 * @version $Id: ad.php 427 2009-12-26 13:45:47Z steven $
 */
require("../libraries/common.inc.php");

require("session_cp.inc.php");
require(LIB_PATH. "typemodel.inc.php");
require(LIB_PATH .'time.class.php');
require(LIB_PATH .'page.class.php');
uses("adzone","ad","attachment");
$tpl_file = "ad";
$attachment = new Attachment('attach');
$adzone = new Adzones();
$ads = new Adses();
$page = new Pages();
$conditions = array();
setvar("AdsStatus", get_cache_type("common_option"));
setvar("Adzones",$adzone->findAll("id,name",null, null,"id desc"));
if (isset($_POST['save'])) {
	$vals = $_POST['ad'];
	if (!empty($_FILES['attach']['name'])) {
		$attachment->if_thumb=false;
		$attachment->if_watermark=false;
		$attachment->insert_new=false;
		$attachment->rename_file = $vals['adzone_id']."-".$time_stamp;
		$attachment->upload_process();
		$vals['source_url'] = URL.$attachment_dir."/".$attachment->file_full_url;
		$vals['source_type'] = $_FILES['attach']['type'];
		$vals['is_image'] = $attachment->is_image;
		$vals['width'] = $attachment->width;
		$vals['height'] = $attachment->height;
	}
	if(!empty($_POST['data']['end_date'])) {
	    $vals['end_date'] = Times::dateConvert($_POST['data']['end_date']);
	}
	$id = $_POST['id'];
	if (!empty($id)) {
		$vals['modified'] = $time_stamp;
		$result = $ads->save($vals, "update", $id);
	}else{
		$vals['created'] = $vals['modified'] = $vals['start_date'] = $time_stamp;
		$result = $ads->save($vals);
	}
	if (!$result) {
		flash();
	}
}
if (isset($_POST['del']) && !empty($_POST['id'])) {
	$result = $ads->del($_POST['id']);
}
if(isset($_POST['up'])&&!empty($_POST['id'])){
	$ids = $_POST['id'];
	foreach($ids as $id){
		$pdb->Execute("UPDATE {$tb_prefix}adses set state=1 where id=".$id);
    }
}
if(isset($_POST['down'])&&!empty($_POST['id'])){
	$ids = $_POST['id'];
	foreach($ids as $id){
		$pdb->Execute("UPDATE {$tb_prefix}adses set state=0 where id=".$id);
    }
}
if (isset($_GET['do'])){
	$do = trim($_GET['do']);
	if (!empty($_GET['id'])) {
		$id = intval($_GET['id']);
	}
	if($do=="del" && !empty($id)) {
		$result = $ads->del($_GET['id'])	;
	}
	if ($do == "edit") {
		if (!empty($id)) {
			$result = $ads->read("*", $id);
			if (!empty($result['end_date'])) {
				$result['end_date'] = date("Y-m-d", $result['end_date']);
			}
			setvar("item",$result);
		}
		$tpl_file = "ad.edit";
		template($tpl_file);
		exit;
	}
	if ($do == "search") {
		if (!empty($_GET['adzone_id'])) {
			$conditions[] = "Ads.adzone_id=".$_GET['adzone_id'];
		}
	}
}
$amount = $ads->findCount();
$page->setPagenav($amount);
$joins[] = "LEFT JOIN {$tb_prefix}adzones az ON az.id=Ads.adzone_id";
$result = $ads->findAll("Ads.*,az.name AS adzone",$joins, $conditions, " Ads.id desc", $page->firstcount, $page->displaypg);
setvar("Items",$result);
setvar("ByPages",$page->pagenav);
template($tpl_file);
?>