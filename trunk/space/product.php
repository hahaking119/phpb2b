<?php
if(!defined('IN_PHPB2B')) exit('Not A Valid Entry Point');
uses("product","producttype");
require(SITE_ROOT.'./libraries/page.php');
$producttype = new Producttypes();
$product = new Products();
$tpl_file = "product";
$conditions = null;

$conditions.= " Product.status=1 and Product.company_id=".$companyinfo['ID'];
$product_types = $producttype->findAll($producttype->common_cols,"Producttype.company_id=".$companyinfo['ID'],"Producttype.id DESC",0,10);
setvar("ProductTypes",$product_types);
if ($_GET['tid']) {
	$conditions.= " and Product.producttype_id=".intval($_GET['tid']);
}
if ($_GET['new'] == 1) {
	$conditions.= " and Product.ifnew=1 ";
}
$company_product_amount = $product->findCount($conditions,"Product.id");
pageft($company_product_amount,16);
$company_products = $product->findAll($product->common_cols,$conditions,"Product.id DESC",$firstcount,$displaypg);
setvar("Products",$company_products);
setvar("ByPages",$pagenav);

template("../skins/".$tplpath.$tpl_file);
?>