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
 * @version $Id: page.php 416 2009-12-26 13:31:08Z steven $
 */
define('CURSCRIPT', 'page');
require("libraries/common.inc.php");
uses("userpage");
$userpage = new Userpages();
$conditions = array();
if (isset($_GET['id'])) {
	$id = intval($_GET['id']);
	$conditions[] = "id=".$id;
}
if (isset($_GET['name'])) {
	$conditions[] = "name='".$_GET['name']."'";
}
$userpage->setCondition($conditions);
$result = $pdb->GetRow("SELECT id,name,title,content,url FROM {$tb_prefix}userpages".$userpage->getCondition());
if (!empty($result)) {
	$viewhelper->setTitle($result['title']);
	setvar("item", $result);
	render("page.index");
}else{
	flash();
}
?>