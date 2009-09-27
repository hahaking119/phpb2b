<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './app/configs/db_session.php');
uses("product","company","member","attachment");
require(SITE_ROOT.'./app/include/page.php');
require("session_cp.inc.php");
$member = new Members();
$attachment = new Attachments();
$company = new Companies();
$product = new Products();
$conditions = "1";
$tpl_file = "product_index";
$product_status = explode(",",lgg('product_status'));
setvar("CheckStatus",$product_status);
setvar("BooleanVars", explode(",",lgg('yes_no')));
setvar("ProductSorts",explode(",",lgg('product_sorts')));
if ($_POST['save'] && !empty($_POST['product']['name'])) {

	$result = false;
	$vals = array();
	$vals = $_POST['product'];
	$pid = intval($_POST['id']);
	if (!empty($_FILES['pic']['name'])) {
        include("../app/include/class.thumb.php");
        $attachment->out_file_dir     = BASE_DIR.'attachment/'.gmdate("Ym");
        $attachment->out_file_name = $time_stamp;
        $attachment->upload_process();
        if ( $attachment->error_no )
        {
            flash("./alert.php","./product.php", lgg("upload_error").$attachment->error_no,0);
        }
        $img = new Image($attachment->saved_upload_name, $attachment->saved_upload_name);
        $img->Thumb();
        $attachment->imageWaterMark($attachment->saved_upload_name, "../images/watermark.png");
        $vals['picture'] = gmdate("Ym")."/".$attachment->parsed_file_name;
	}
	array_walk($vals, "uatrim");
	if($pid){
		$vals['modified'] = $time_stamp;
		$result = $product->save($vals, "update", $pid);
	}else{
		$vals['created'] = $time_stamp;
		$result = $product->save($vals);
	}
	if ($result) {
		flash("alert.php");
	}else{
		flash("alert.php","./product.php",null,0,null,"./product.php");
	}
}

if (isset($_POST['recommend'])) {
	//$result = $product->saveField("ifcommend", 1, $_POST['pid']);
	foreach($_POST['pid'] as $val){
		$commend_now = $product->field("ifcommend", "id=".$val);
		if($commend_now=="0"){
			$product->saveField("ifcommend", "1", intval($val));
		}else{
			$product->saveField("ifcommend", "0", intval($val));
		}
	}
}
if (isset($_POST['check'])) {
	if(!empty($_POST['pid'])){
		if (isset($_POST['check']['t_1'])) {
			$tmp_to = 1;
		}elseif (isset($_POST['check']['t_2'])){
			$tmp_to = 2;
		}elseif (isset($_POST['check']['t_3'])){
			$tmp_to = 3;
		}else{
			$tmp_to = 0;
		}
		$result = $product->checkProducts($_POST['pid'], $tmp_to);
	}
}

if (isset($_POST['del'])) {
	$deleted = false;
    foreach ($_POST['pid'] as $val) {
    	$picture = $product->field("picture", "id=".$val);
    	@unlink($media_paths['attachment_dir'].$picture);
    	@unlink($media_paths['attachment_dir'].$picture.".small.jpg"););
    }
	if (is_array($_POST['pid'])) {
		$deleted = $product->del($_POST['pid']);
		if($deleted){
			flash("./alert.php");
		}else{
			flash("./alert.php",null,null,0);
		}
	}else{
		flash("./alert.php",null,null,0);
	}
}
if($_GET['action'] == "mod"){
	if($_GET['id']){
		$pid = intval($_GET['id']);
		$res = $product->read("*",$pid);
		setvar("P",$res);
		unset($res);
	}
	$tpl_file = "product_edit";
}
if (isset($_GET['search'])) {
	if(!empty($_GET['member']['id'])) {
		$conditions.= " AND Product.member_id='".$_GET['member']['id']."'";
		//$ujoins.= " left join ".$member->getTable(true)." on Product.member_id=Member.id";
	}
	if($_GET['product']['sort_id']!="-1") $conditions.= " AND Product.sort_id = ".$_GET['product']['sort_id'];
	if(!empty($_GET['company']['name'])) {
		$conditions.= " AND Company.name like '%".$_GET['company']['name']."%'";
		$ujoins.= " left join ".$company->getTable(true)." on Company.id=Product.company_id";
	}
	if($_GET['product']['status']!="-1") $conditions.= " AND Product.status=".$_GET['product']['status'];
	if(!empty($_GET['product']['name'])) $conditions.= " AND Product.name like '%".$_GET['product']['name']."%'";
	if($_GET['industryid']) $conditions.= " AND Product.industry_id =".$_GET['industryid'];
	if($_GET['provinceid']) $conditions.= " AND Company.province_code_id =".$_GET['provinceid'];
	if ($_GET['FromDate'] && $_GET['FromDate']!="None" && $_GET['ToDate'] && $_GET['ToDate']!="None") {
		$conditions.= " AND Product.created BETWEEN ";
		$conditions.= uaDateConvert($_GET['FromDate']);
		$conditions.= " AND ";
		$conditions.= uaDateConvert($_GET['ToDate']);
	}
}
$amount = $product->findCount($conditions,"Product.id", null, $ujoins);
$joins = array(
	"Company"=>array("fullTableName"=>$company->getTable(true),"foreignKey"=>"company_id","fields"=>"Company.name AS CompanyName")
	);
pageft($amount,$display_eve_page);
$fields = "Product.id AS PID,Product.company_id AS CompanyID,Company.id AS CID,Product.name AS ProductName,Product.status AS ProductStatus,Product.created AS CreateDate,Product.ifcommend as Ifcommend, Product.state as ProductState,Product.picture as ProductPicture ";
setvar("ProductList",$product->findAll($fields,$conditions,"Product.id DESC",$firstcount,$displaypg));
uaAssign(array("Amount"=>$amount,"PageHeader"=>$page_header,"ByPages"=>$pagenav));

setvar("Today", mktime(0,0,0,date("m") ,date("d"),date("Y")));
template("pb-admin/".$tpl_file);
?>