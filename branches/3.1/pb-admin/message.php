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
 * @version $Id: message.php 427 2009-12-26 13:45:47Z steven $
 */
require("../libraries/common.inc.php");
uses("message");
require(PHPB2B_ROOT.'libraries/page.class.php');
require("session_cp.inc.php");
$message = new Messages();
$page = new Pages();
$conditions = array();
$tpl_file = "message";
if (isset($_POST['del']) && is_array($_POST['id'])) {
	$deleted = $message->del($_POST['id']);
	if (!$deleted) {
		flash();
	}
}
if (isset($_POST['save'])) {
	$sended = $message->SendToUser($current_adminer, $_POST['to_username'], $_POST['data']['message']);
	if (!$sended) {
		flash(null, null, 0);
	}else{
		pheader("location:message.php");
	}
}
if (isset($_GET['do'])) {
	$do = trim($_GET['do']);
	if (!empty($_GET['id'])) {
		$id = intval($_GET['id']);
	}
	if ($do == 'search') {
		if (!empty($_GET['q'])) $conditions[]= "title like '%".trim($_GET['q'])."%'";
	}
	if ($do == "send") {
		$tpl_file = "message.send";
		template($tpl_file);
		exit;
	}
	if ($do=="del" && !empty($id)) {
		$message->del($id);
	}
}
$amount = $pdb->GetOne("select count(id) from {$tb_prefix}messages");
$page->setPagenav($amount);
$result = $message->findAll("id,cache_from_username,cache_to_username,title,content,created,created as pubdate", null, $conditions, "id DESC", $page->firstcount, $page->displaypg);
setvar("Items", $result);
setvar("ByPages", $page->getPagenav());
template($tpl_file);
?>