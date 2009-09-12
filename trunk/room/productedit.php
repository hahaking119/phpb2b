<?php
$inc_path = "../";$ua_sm_compile_dir = "room/";
require($inc_path."global.php");
require("session.php");
uaCheckPermission(2);
uses("trade","member","producttype","product","industry","setting","company","keyword");
$setting = new Settings();
$keyword = new Keywords();
$company = new Companies();
$industry = new Industries();
$member = new Members();
$product = new Products();
$producttype = new Producttypes();
$trade = new Trades();
$tpl_file = "product_edit";
$conditions = " and member_id=".$_SESSION['MemberID'];
$company_id = $company->field("id", "member_id=".$_SESSION['MemberID']);
if(!empty($company_id)) $company->checkStatus($company_id);
$list = $producttype->findAll($producttype->common_cols, "member_id=".$_SESSION['MemberID']," id DESC",0,10);
if (($_GET['action']=="mod") && (!empty($_GET['id']))) {
	$productinfo = $product->read(null,$_GET['id'],null,$conditions);
	if (empty($productinfo)) {
		PB_goto("./tip.php?id=1005");
	}else {
		$current_industry = $industry->searchParentIndustry($productinfo['ProductIndustryId']);
		if (is_array($current_industry)) {
			$search_industry_ids = implode(",",$current_industry);
			setvar("CurrentIndustry",$g_db->GetArray("select name AS IndustryName from ".$industry->getTable(true)." where id in (".$search_industry_ids.")"));
		}
		if(!empty($productinfo['ProductKeywords'])){
		$_k = $g_db->Execute("select title from {$tb_prefix}keywords where id in (".$productinfo['ProductKeywords'].")");
		$productinfo['ProductKeywords'] = $_k;
		}
		setvar("ProductInfo",$productinfo);
	}
}

if (isset($_POST['action'])) {
	if($_POST['action']=="product_edit" && !empty($_POST['prod_name'])){
		uses("access", "attachment");
		$access = new Accesses();
		$attachment = new Attachments();
		$vals = array();
		$now_product_amount = $product->findCount("member_id=".$_SESSION['MemberID']);
		$max_product_amount = intval($access->field("max_product","membertype_id=".$ua_user['user_type']));
		$check_product_update = intval($access->field("check_product_update","membertype_id=".$ua_user['user_type']));
		if ($check_product_update=="0") {
			$vals['status'] = 1;
		}else {
			$vals['status'] = 0;
			$message_info = lgg('msg_wait_check');
		}
		$pid = intval($_POST['id']);
		if ($max_product_amount!=0 && $now_product_amount>=$max_product_amount && (empty($pid))) {
			$msg = sprintf(lgg('mx_prod_day'), $max_product_amount);
			flash("./tip.php","./product.php",$msg,0);
		}
    	if (!empty($_FILES['pic']['name'])) {
    	    include("../app/include/class.thumb.php");
    	    $attachment->out_file_dir     = BASE_DIR.'attachment/'.gmdate("Ym");
    	    $attachment->out_file_name = $_SESSION['MemberID']."_".$pid."_".$time_stamp;
    	    $attachment->upload_process();
    	    if ( $attachment->error_no )
    	    {
    	        flash("./tip.php","./product.php", lgg("upload_error").$attachment->error_no,0);
    	    }
    	    $img = new Image($attachment->saved_upload_name, $attachment->saved_upload_name);
    	    $img->Thumb();
    		$attachment->imageWaterMark($attachment->saved_upload_name, "../images/watermark.png");
    	    $vals['picture'] = gmdate("Ym")."/".$attachment->parsed_file_name;
    	}
		$industryid = 0;

		if ($_POST['cindustry']) {
			$industryid = $_POST['cindustry'];
		}else if($_POST['bindustry']){
			$industryid = $_POST['bindustry'];
		}else if($_POST['aindustry']){
			$industryid = $_POST['aindustry'];
		}
		if($industryid)
		$vals['industry_id'] = $industryid;
		$vals['name'] = $_POST['prod_name'];
		$vals['sort_id'] = $_POST['sort_id'];
		$vals['sn'] = $_POST['prod_sn'];
		$vals['spec'] = $_POST['scale'];
		$vals['packing_content'] = $_POST['package'];
		$vals['price'] = $_POST['price'];
		$vals['produce_area'] = $_POST['fromwhere'];
		$vals['content'] = $_POST['content'];
		$vals['producttype_id'] = $_POST['product_type'];
		//$vals['keywords'] = uaConvertComma($_POST['keywords']);

		array_walk($vals,"uatrim");
		//if(!empty($vals['keywords'])){
		//	$keyword->importKeys($vals['keywords'], $pid, 4);
		//}
		if (empty($company_id)) {
			flash("./tip.php","./company.php", lgg('re_complete_corp'),0);
		}
		if (!empty($pid)) {
			$result = $product->save($vals, "update", $pid, null, $conditions);
		}else {
			$vals['member_id'] = $_SESSION['MemberID'];
			$vals['company_id'] = $company_id;
			$vals['created'] = $time_stamp;
			$result = $product->save($vals);
			$new_id = $g_db->Insert_ID();
			$keyword->setKeywordId($_POST['keywords'], $new_id, 'products');
			$g_db->Execute("update {$tb_prefix}products set keywords='".$keyword->getKeywordId()."' where id=".$new_id);
			uses("stat");
			$stat = new Stats();
			$stat->Add("product");
            $industry->updateModelAmount($industryid, "product_amount");
		}
		if ($result) {
			$message_info = lgg('action_complete');
			flash("./tip.php","./product.php",$message_info);
		}else {
			flash("./tip.php","./product.php",$message_info,0);
		}
	}
}
setvar("ProductSorts",explode(",",lgg('product_sorts')));
setvar("ProductTypes",$list);
template($tpl_file);
?>