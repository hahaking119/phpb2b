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
 * @version $Id: newstype.php 427 2009-12-26 13:45:47Z steven $
 */
require("../libraries/common.inc.php");
uses("newstype");
require(LIB_PATH. 'page.class.php');
require(LIB_PATH. 'cache.class.php');
require("session_cp.inc.php");
$newstype = new Newstypes();
$cache = new Caches();
$page = new Pages();
$conditions = array();
$tpl_file = "newstype";
setvar("NewstypeOptions", $newstype->getTypeOptions());
if (isset($_POST['save']) && !empty($_POST['data']['newstype']['name'])) {
	$vals = array();
	$vals = $_POST['data']['newstype'];
	if (!empty($_POST['id'])) {
		$result = $newstype->save($vals, "update", $_POST['id']);
	}else{
		$vals['created'] = $time_stamp;
		$result = $newstype->save($vals);
	}
	if (!$result) {
		flash();
	}
	$cache->writeCache('newstype', 'newstype');
}
if (isset($_GET['do'])) {
	$do = trim($_GET['do']);
	if (!empty($_GET['id'])) {
		$id = intval($_GET['id']);
	}
	if ($do == 'search') {
		if (isset($_GET['newstype']['name'])) $conditions[]= "Newstype.name like '%".trim($_GET['newstype']['name'])."%'";
	}
	if($do == "del" && !empty($id)){
		$newstype->del($id);
	}
	if ($do == "edit") {
		if(!empty($id)){
			$res= $newstype->read("*",$id);
			setvar("NewstypeOptions", $newstype->getTypeOptions($res['parent_id']));
			setvar("item",$res);
		}
		$tpl_file = "newstype.edit";
		template($tpl_file);
		exit;
	}
}
$amount = $newstype->findCount(null, $conditions,"id");
$page->setPagenav($amount);
$newstype_list = $newstype->findAll("*", null, $conditions, "id DESC", $page->firstcount, $page->displaypg);
setvar("Items",$newstype_list);
uaAssign(array("ByPages"=>$page->pagenav));
if (isset($_POST['del']) && is_array($_POST['id'])) {
	$deleted = $newstype->del($_POST['id']);
	if (!$deleted) {
		flash();
	}
}
template($tpl_file);
?>