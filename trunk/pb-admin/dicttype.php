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
 * @version $Id: dicttype.php 427 2009-12-26 13:45:47Z steven $
 */
require("../libraries/common.inc.php");
uses("dicttype");
require(LIB_PATH. 'page.class.php');
require("session_cp.inc.php");
$dicttype = new dicttypes();
$page = new Pages();
$tpl_file = "dicttype";
$conditions = array();
if (isset($_POST['del']) && is_array($_POST['id'])) {
	$deleted = $dicttype->del($_POST['id']);
	if (!$deleted) {
		flash();
	}
}
if (isset($_GET['do'])) {
	$do = trim($_GET['do']);
	if ($do =="search" && !empty($_GET['q'])) {
		$conditions[] = "name like '%".trim($_GET['q'])."%'";
	}
	if ($do == "del" && !empty($_GET['id'])) {
		$dicttype->del($_GET['id']);
	}
	if($do == "edit"){
		setvar("dicttypeOptions", $dicttype->getTypeOptions());
		if(isset($_GET['id'])){
			$id = intval($_GET['id']);
			$res= $dicttype->read("*",$id);
			setvar("item",$res);
		}
		$tpl_file = "dicttype.edit";
		template($tpl_file);
		exit;
	}
}
if (isset($_POST['save'])) {
	$vals = array();
	$vals = $_POST['data']['dicttype'];
	if (!empty($_POST['id'])) {
		$result = $dicttype->save($vals, "update", $_POST['id']);
	}else{
		$result = $dicttype->save($vals);
	}
	if (!$result) {
		flash();
	}
}
$amount = $dicttype->findCount(null, $conditions,"id");
$page->setPagenav($amount);
setvar("Items", $dicttype->findAll("*", null, $conditions, "parent_id ASC,display_order ASC", $page->firstcount, $page->displaypg));
setvar("ByPages",$page->pagenav);
template($tpl_file);
?>