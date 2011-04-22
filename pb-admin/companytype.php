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
 * @version $Id: companytype.php 427 2009-12-26 13:45:47Z steven $
 */
require("../libraries/common.inc.php");
require("session_cp.inc.php");
require(LIB_PATH. 'cache.class.php');
uses("companytype");
$cache = new Caches();
$conditions = array();
$companytype = new Companytypes();
$tpl_file = "companytype";
if (isset($_POST['del']) && !empty($_POST['id'])) {
	$result = $companytype->del($_POST['id']);
	if (!$result) {
		flash();
	}
}
if (isset($_POST['save']) && !empty($_POST['data']['companytype']['name'])) {
	$companytype->setParams();
	if (isset($_POST['data']['companytype']['id'])) {
		$result = $companytype->save($companytype->params['data']['companytype'], "update", intval($_POST['data']['companytype']['id']));
	}else{
		$result = $companytype->save($companytype->params['data']['companytype']);
	}
	$cache->writeCache('companytype', 'companytype');
	pheader("location:companytype.php");
}
if (isset($_GET['do'])) {
	$do = trim($_GET['do']);
	if (!empty($_GET['id'])) {
		$id = intval($_GET['id']);
	}
	if ($do=="edit") {
		if($id){
			$result = $companytype->read("*",$id);
			setvar("item",$result);
		}
		$tpl_file = "companytype.edit";
		template($tpl_file);
		exit;
	}
}
$result = $companytype->findAll("id,name,created",null, $conditions, " id DESC");
setvar("Items",$result);
template($tpl_file);
?>