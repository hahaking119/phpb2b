<?php
if(!defined('IN_UALINK')) exit('Access Denied');
$fields = "Company.description AS CompanyDescription,";
uses("product");
$product = new Products();
$conditions = " Product.status=1 and Product.company_id=".$companyinfo['ID'];
$company_products = $product->findAll($product->common_cols,$conditions,"Product.id DESC",0,8);
setvar("Products",$company_products);
template($tplpath."index");
?>