<?php
/**
 * PHPB2B :  Opensource B2B Script (http://www.phpb2b.com/)
 * Copyright (C) 2007-2010, Ualink. All Rights Reserved.
 * 
 * Licensed under The Languages Packages Licenses.
 * Support : phpb2b@hotmail.com
 * 
 * @version $Revision: 1393 $
 */
require("../libraries/common.inc.php");
uses("expo","member","attachment","typeoption");
require(PHPB2B_ROOT.'libraries/page.class.php');
require(CACHE_PATH. 'cache_type.php');
require("session_cp.inc.php");
require(LIB_PATH. "time.class.php");
$attachment = new Attachment('pic');
$expo = new Expoes();
$page = new Pages();
$member = new Members();
$typeoption = new Typeoption();
$conditions = null;
$tpl_file = "fair";
setvar("Expotypes", $_PB_CACHE['expotype']);
setvar("ExpoStatus", $typeoption->get_cache_type("common_option"));
setvar("AskAction", $typeoption->get_cache_type("common_option"));
if (isset($_GET['do'])) {
	$do = trim($_GET['do']);
	if (!empty($_GET['id'])) {
		$id = intval($_GET['id']);
	}
	if ($do == "del" && !empty($id)){
		$deleted = false;
		$result = $expo->del($id);
		if(!$result)
		{
			flash();
		}
	}	
	if ($do == "edit") {
		$tmp_info = null;
		if(!empty($id)){
			$tmp_info = $expo->read("*",$id);
			if(!empty($tmp_info['begin_time'])) $tmp_info['begin_date'] = date("Y-m-d", $tmp_info['begin_time']);
			if(!empty($tmp_info['end_time'])) $tmp_info['end_date'] = date("Y-m-d", $tmp_info['end_time']);
			if(!empty($tmp_info['picture'])) $tmp_info['image'] = pb_get_attachmenturl($tmp_info['picture'], "../", 'small');
			if(!empty($fair_companies)){
				$fair_companies = unserialize($tmp_info['ExpoEw']);
				setvar("FairCompanies", implode(",", $fair_companies));
			}
			setvar("item",$tmp_info);
		}
		$tpl_file = "fair.edit";
		template($tpl_file);
		exit;
	}
}
if (isset($_POST['save']) && !empty($_POST['data']['expo']['name'])) {
	$expo->setParams();
	if (isset($_POST['id'])) {
		$id = intval($_POST['id']);
	}	
	if (!empty($_POST['data']['begin_time'])) {
		$expo->params['data']['expo']['begin_time'] = Times::dateConvert($_POST['data']['begin_time']);
	}
	if (!empty($_POST['data']['end_time'])) {
		$expo->params['data']['expo']['end_time'] = Times::dateConvert($_POST['data']['end_time']);
	}
	$expo->params['data']['expo']['status'] = 1;
	if (!empty($id)) {
		if (!empty($_FILES['pic']['name'])) {
			$attachment->insert_new = false;
			$attachment->rename_file = "fair-".$id;
			$attachment->upload_process();
			$expo->params['data']['expo']['picture'] = $attachment->file_full_url;
		}
		$expo->params['data']['expo']['modified'] = $time_stamp;
		$result = $expo->save($expo->params['data']['expo'], "update", $id);
	}else{
		$expo->params['data']['expo']['created'] = $expo->params['data']['expo']['modified'] = $time_stamp;
		if (!empty($_FILES['pic']['name'])) {
			$attachment->rename_file = "fair-".($fair->getMaxId()+1);
			$attachment->upload_process();
			$expo->params['data']['expo']['picture'] = $attachment->file_full_url;
		}
		$result = $expo->save($expo->params['data']['expo']);
	}
	if(!$result)
	{
		flash();
	}

}
if (isset($_POST['quickadd']) && (!empty($_POST['expo']['name']))) {
	$vals = $_POST['expo'];
	$vals['created'] = $vals['modified'] = $time_stamp;
	$result = $expo->save($vals);
}
if (isset($_POST['del']) && !empty($_POST['id'])){
	$deleted = false;
	$result = $expo->del($_POST['id']);
	if(!$result)
	{
		flash();
	}
}
if (isset($_POST['up']) && !empty($_POST['id'])){
	$ids = implode(",", $_POST['id']);
	$result = $pdb->Execute("UPDATE ".$expo->getTable()." SET if_commend=1 WHERE id IN (".$ids.")");
	if(!$result)
	{
		flash();
	}
}
$amount = $expo->findCount();
$page->setPagenav($amount);
$fields = "*";
$result = $expo->findAll($fields,null, null,"id DESC",$page->firstcount,$page->displaypg);
if (!empty($result)) {
	for($i=0; $i<count($result); $i++){
		if(($result[$i]['begin_time'])) $result[$i]['begin_date'] = date("Y-m-d", $result[$i]['begin_time']);
		if(($result[$i]['end_time'])) $result[$i]['end_date'] = date("Y-m-d", $result[$i]['end_time']);
		if(($result[$i]['picture'])) $result[$i]['image'] = pb_get_attachmenturl($result[$i]['picture']);
	}
}
setvar("Items",$result);
setvar("ByPages",$page->pagenav);
template($tpl_file);
?>