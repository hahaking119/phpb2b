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
require("../libraries/common.inc.php");
require("room.share.php");
uses("product","producttype","form","attachment","tag");
require(PHPB2B_ROOT.'libraries/page.class.php');
require(CACHE_PATH. 'cache_membergroup.php');
require(CACHE_PATH. 'cache_productsort.php');
check_permission("product");
$page = new Pages();
$tag = new Tags();
$form = new Forms();
$product = new Products();
$producttype = new Producttypes();
$attachment = new Attachment('pic');
$conditions[] = "member_id = ".$_SESSION['MemberID'];
setvar("ProductSorts", $_PB_CACHE['productsort']);
setvar("ProductTypes",$producttype->findAll('id,name', null, $conditions, "id DESC"));
$tpl_file = "product";
if (empty($companyinfo)) {
	flash("pls_complete_company_info", "company.php", 0);
}
if (isset($_POST['save'])) {
	$company->newCheckStatus($companyinfo['status']);
	if(!empty($_POST['data']['product'])){
		$product->setParams();
		$now_product_amount = $product->findCount(null, "created>".$today_start." AND member_id=".$_SESSION['MemberID']);
		$check_product_update = $g['product_check'];
		if ($check_product_update == 0) {
			$product->params['data']['product']['status'] = 1;
		}else {
			$product->params['data']['product']['status'] = 0;
			$message_info = 'msg_wait_check';
		}
		if(isset($_POST['id'])){
			$id = intval($_POST['id']);
		}
    	if (!empty($_FILES['pic']['name'])) {
    		$attachment->rename_file = $_SESSION['MemberID']."_".$id."_".$time_stamp;
			$attachment->upload_process();    		
    	    $product->params['data']['product']['picture'] = $attachment->file_full_url;
    	}
    	$form_type_id = 2;
		$product->params['data']['product']['tag_ids'] = $tag->setTagId($_POST['data']['tag']);
		if (!empty($id)) {
			$item_ids = $form->Add($id,$_POST['data']['formitem'], 1, $form_type_id);
			$product->params['data']['product']['modified'] = $time_stamp;
			$product->params['data']['product']['formattribute_ids'] = $item_ids;
			$result = $product->save($product->params['data']['product'], "update", $id, null, $conditions);
		}else {
			if ($g['max_product'] && $now_product_amount>=$g['max_product']) {
				flash('one_day_max');
			}
			$product->params['data']['product']['member_id'] = $_SESSION['MemberID'];
			$product->params['data']['product']['company_id'] = $company_id;
			$product->params['data']['product']['created'] = $product->params['data']['product']['modified'] = $time_stamp;
			$result = $product->save($product->params['data']['product']);
			$new_id = $product->table_name."_id";
			$product_id = $product->$new_id;
			$item_ids = $form->Add($product_id, $_POST['data']['formitem'], 1, $form_type_id);
			if($item_ids){
				$pdb->Execute("UPDATE {$tb_prefix}products SET formattribute_ids='{$item_ids}' type_id='{$form_type_id}' WHERE id=".$product_id);
			}
		}
		if ($result) {
			flash($message_info?$message_info:"success");
		}else {
			flash();
		}
	}
}
if (isset($_GET['do'])) {
	$do = trim($_GET['do']);
	if (isset($_GET['id'])) {
		$id = intval($_GET['id']);
	}
	if ($do == "edit") {
		if(!empty($company_id)) {
			$company->primaryKey = "member_id";
			$company->checkStatus($company_id);
			$company_info = $company->getInfoById($company_id);
			setvar("CompanyInfo",$company_info);
		}
		setvar("Forms", $form->getAttributes());
		if (!empty($id)) {
			$productinfo = $product->read("*", $id, null, $conditions);
			if (empty($productinfo)) {
				flash("action_failed");
			}else {
				if (!empty($productinfo['picture'])) {
					$productinfo['image'] = pb_get_attachmenturl($productinfo['picture'], '../');
				}		   
				if(!empty($productinfo['tag_ids'])){
					$tag->getTagsByIds($productinfo['tag_ids'], true);
					$productinfo['tag'] = $tag->tag;
				}
				setvar("Forms", $form->getAttributes(explode(",", $productinfo['formattribute_ids'])));
			}
		}else{
			$productinfo['industry_id1'] = $companyinfo['industry_id1'];
			$productinfo['industry_id2'] = $companyinfo['industry_id2'];
			$productinfo['industry_id3'] = $companyinfo['industry_id3'];
			$productinfo['area_id1'] = $companyinfo['area_id1'];
			$productinfo['area_id2'] = $companyinfo['area_id2'];
			$productinfo['area_id3'] = $companyinfo['area_id3'];
		}
		setvar("item",$productinfo);
		$tpl_file = "product_edit";
		template($tpl_file);
		exit;
	}
	if ($do == "state") {
		switch ($_GET['type']) {
			case "up":
				$state = 1;
				break;
			case "down":
				$state = 0;
				break;
			default:
				$state = 0;
				break;
		}
		if (!empty($id)) {
			$vals['state'] = $state;
			$updated = $pdb->Execute("UPDATE {$tb_prefix}products SET state={$state} WHERE id={$id} AND member_id={$_SESSION['MemberID']}");
			if (!$updated) {
				flash();
			}
		}else{
			flash();
		}
	}
	if ($do == "del" && !empty($id)) {
		$res = $product->read("id",$id);
		if($res){
			if(!$product->del($_GET['id'], $conditions)){
				flash();
			}
		}else {
			flash("data_not_exists");;
		}
	}	
}
if (isset($_GET['typeid'])) {
	$conditions[] = "producttype_id = ".$_GET['typeid'];
}
$amount = $product->findCount(null, $conditions,"Product.id");
$page->setPagenav($amount);
$result = $product->findAll("sort_id,id,name,picture,content,created,status,state", null, $conditions, "Product.id DESC", $page->firstcount, $page->displaypg);
if ($result) {
	$i_count = count($result);
	for ($i=0; $i<$i_count; $i++) {
		$result[$i]['image'] = pb_get_attachmenturl($result[$i]['picture'], '../', 'small');
	}
}
setvar("Items",$result);
setvar("nlink",$page->nextpage_link);
setvar("plink", $page->previouspage_link);
setvar("CheckStatus", explode(",",L('product_status', 'tpl')));
uaAssign(array("pagenav"=>$page->getPagenav()));
template($tpl_file);
?>