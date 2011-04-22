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
 * @version $Id: product.php 481 2009-12-28 01:05:06Z steven $
 */
if(!defined('IN_PHPB2B')) exit('Not A Valid Entry Point');
uses("product");
require(PHPB2B_ROOT.'libraries/page.class.php');
$product = new Products();
$page = new Pages();
$page->displaypg = 20;
$tpl_file = "product";
$conditions = null;
$conditions[] = "Product.status=1 AND Product.company_id=".$company->info['id'];
if (isset($_GET['typeid'])) {
	$conditions[]= "producttype_id=".intval($_GET['typeid']);
}
if (isset($_GET['new']) && $_GET['new'] == 1) {
	$conditions[]= "ifnew=1";
}
$amount = $product->findCount(null, $conditions,"id");
$page->setPagenav($amount);
$result = $product->findAll('id,picture,name',null, $conditions,"id DESC",$page->firstcount,$page->displaypg);
if (!empty($result)) {
	$count = count($result);
	for($i=0; $i<$count; $i++){
		$result[$i]['image'] = URL. pb_get_attachmenturl($result[$i]['picture'], '', 'small');
	}
}
setvar("Items",$result);
setvar("ByPages",$page->pagenav);
$space->render($tpl_file);
?>