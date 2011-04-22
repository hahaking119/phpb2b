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
 * @version $Id: detail.php 433 2009-12-26 13:47:01Z cht117 $
 */
define('CURSCRIPT', 'detail');
require("../libraries/common.inc.php");
uses("market");
$market = new Markets();
$viewhelper->setPosition(L("market", "tpl"), "market/");
if (isset($_GET['id'])) {
	$id = intval($_GET['id']);
	$sql = "select * from {$tb_prefix}markets m where id={$id}";
	$item = $pdb->GetRow($sql);
}
if (!empty($item)) {
	$seo_description = utf_substr($item['content'], 100);
	$item['content'] = nl2br($item['content']);
	$viewhelper->setTitle($item['name']);
	if (isset($item['status'])) {
		if($item['status']==0){
			$item['content'] = L('under_checking', 'msg', $item['name']);
		}
	}
	$item['image'] = pb_get_attachmenturl($item['picture']);
	setvar("item",$item);	
}else{
	flash("data_not_exists");
}
render("market.detail");
?>