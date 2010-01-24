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
 * @version $Id: help.php 427 2009-12-26 13:45:47Z steven $
 */
require("../libraries/common.inc.php");
uses("helptype","help");
require(PHPB2B_ROOT.'libraries/page.class.php');
require("session_cp.inc.php");
$help = new Helps();
$page = new Pages();
$helptype = new Helptypes();
$tpl_file = "help";
setvar("HelpTypes", $helptype->data);
if (isset($_GET['do'])) {
	$do = trim($_GET['do']);
	if (!empty($_GET['id'])) {
		$id = intval($_GET['id']);
	}
	if ($do == "search") {
		if(!empty($_GET['help']['title'])) {
			$search_title = $_GET['help']['title'];
			$conditions = "title like '%".$search_title."%'";
		}
	}
	if ($do == "edit") {
		setvar("HelptypeOptions", $helptype_option = $helptype->getTypeOptions('', 3));
		if(!empty($id)){
			setvar("HelptypeOptions", $helptype_option = $helptype->getTypeOptions($item['helptype_id'], 3));
			setvar("item",$item = $help->read("*",$id));
		}
		$tpl_file = "help.edit";
		template($tpl_file);
		exit;
	}
}
if(isset($_POST['save']) && !empty($_POST['help'])){
	$vals = $_POST['help'];
	if(isset($_POST['id'])){
		$id = intval($_POST['id']);
	}
	if(!empty($id)){
		$vals['modified'] = $time_stamp;
		$result = $help->save($vals, "update", $id);
	}else{
		$vals['created'] = $vals['modified'] = $time_stamp;
		$result = $help->save($vals);
	}
	if (!$result) {
		flash();
	}
}
if (isset($_REQUEST['del']) && !empty($_REQUEST['id'])){
	$deleted = false;
	$deleted = $help->del($_REQUEST['id']);
}
$amount = $help->findCount(null, $conditions,"id");
$page->setPagenav($amount);
$result = $help->findAll("Help.id,Help.title,ht.title AS typename,Help.content", array("LEFT JOIN {$tb_prefix}helptypes ht ON Help.helptype_id=ht.id"), $conditions, "Help.id DESC", $page->firstcount, $page->displaypg);
setvar("Items", $result);
setvar("HelptypeOptions", $helptype_option = $helptype->getTypeOptions('', 3));
setvar("ByPages", $page->pagenav);
template($tpl_file);
?>