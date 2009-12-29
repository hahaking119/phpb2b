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
 * @version $Id: helptype.php 427 2009-12-26 13:45:47Z steven $
 */
require("../libraries/common.inc.php");
uses("helptype");
require(LIB_PATH. 'page.class.php');
require("session_cp.inc.php");
$helptype = new Helptypes();
$page = new Pages();
$tpl_file = "helptype";
$conditions = array();
if (isset($_POST['del']) && is_array($_POST['id'])) {
	$deleted = $helptype->del($_POST['id']);
	if (!$deleted) {
		flash();
	}
}
if (isset($_GET['do'])) {
	$do = trim($_GET['do']);
	if ($do =="search" && !empty($_GET['q'])) {
		$conditions[] = "title like '%".trim($_GET['q'])."%'";
	}
	if ($do == "del" && !empty($_GET['id'])) {
		$helptype->del($_GET['id']);
	}
	if($do == "edit"){
		if(isset($_GET['id'])){
			$id = intval($_GET['id']);
			$res= $helptype->read("*",$id);
			setvar("HelptypeOptions", $helptype->getTypeOptions($res['parent_id']));
			setvar("item",$res);
		}
		$tpl_file = "helptype.edit";
		template($tpl_file);
		exit;
	}
}
if (isset($_POST['save'])) {
	$vals = array();
	$vals = $_POST['helptype'];
	if (!empty($_POST['id'])) {
		$result = $helptype->save($vals, "update", $_POST['id']);
	}else{
		$result = $helptype->save($vals);
	}
	if (!$result) {
		flash();
	}
}
$amount = $helptype->findCount(null, $conditions,"id");
$page->setPagenav($amount);
setvar("Items", $helptype->findAll("*", null, $conditions, "id DESC", $page->firstcount, $page->displaypg));
setvar("ByPages",$page->pagenav);
template($tpl_file);
?>