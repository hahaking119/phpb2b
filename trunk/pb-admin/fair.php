<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './app/configs/db_session.php');
require(LIB_PATH .'time.class.php');
uses("expo","member","company", "expotype","attachment");
require("./fckeditor/fckeditor.php") ;
require(SITE_ROOT.'./libraries/page.php');
require("session_cp.inc.php");
$attachment = new Attachments();
$expo = new Expoes();
$expotype = new Expotypes();
$member = new Members();
$company = new Companies();
$conditions = null;
$tpl_file = "fair_index";
$all_expotype = null;
$all_expotype = $expotype->findAll("id as OptionId, name as OptionName");
$all_expotype = UaController::generateList($all_expotype);
setvar("ExpotypeList", $all_expotype);
setvar("ExpoStatus", explode(",",lgg('yes_no')));
if (isset($_POST['save']) && !empty($_POST['Expo']['ea'])) {
	$vals = array();
	$vals = $_POST['Expo'];
	if(isset($_POST['countryid'])) $vals['country_id'] = $_POST['countryid'];
	if(isset($_POST['provinceid'])) $vals['province_id'] = $_POST['provinceid'];
	if(isset($_POST['cityid'])) $vals['city_id'] = $_POST['cityid'];
	$primary_id = intval($_POST['id']);
	if (!empty($_FILES['pic']['name'])) {
        include("../libraries/class.thumb.php");
        $attachment->out_file_dir     = BASE_DIR.'attachment/'.gmdate("Ym");
        $attachment->out_file_name = $time_stamp;
        $attachment->upload_process();
        if ( $attachment->error_no )
        {
            flash("./alert.php","./product.php", lgg("upload_error").$attachment->error_no,0);
        }
        $img = new Image($attachment->saved_upload_name, $attachment->saved_upload_name);
        $img->Thumb(201, 150);
        $attachment->imageWaterMark($attachment->saved_upload_name, "../images/watermark.png");
        $vals['picture'] = gmdate("Ym")."/".$attachment->parsed_file_name;
	}
	$vals['eb'] = $time_stamp;
	$vals['ed'] = Times::dateConvert($_POST['ExpoEdTime']);
	$vals['ef'] = Times::dateConvert($_POST['ExpoEfTime']);
	$vals['eg'] = Times::dateConvert($_POST['ExpoEgTime']);
	$result = $expo->save($vals);
	if(!$result)
	{
		flash("./alert.php","./fair.php?action=list",null,0);
	}

}
if (isset($_POST['quickadd']) && (!empty($_POST['Expo']['ea']))) {
	$vals = $_POST['Expo'];
	$vals['eb'] = $time_stamp;
	$result = $expo->save($vals);
}
if (isset($_POST['del_x']) && !empty($_POST['id'])){
	$deleted = false;
	$result = $expo->del($_POST['id']);
	if(!$result)
	{
		flash("./alert.php","./fair.php?action=list",null,0);
	}
}
if (isset($_POST['up_x']) && !empty($_POST['id'])){
	$ids = implode(",", $_POST['id']);
	$result = $g_db->Execute("update ".$expo->getTable()." set if_recommend=1 where id in (".$ids.")");
	if(!$result)
	{
		flash("./alert.php","./fair.php?action=list",null,0);
	}
}
if ($_GET['action']=="del" && !empty($_GET['id'])){
	$deleted = false;
	$result = $expo->del($_GET['id']);
	if(!$result)
	{
		flash("./alert.php","./fair.php?action=list",null,0);
	}
}

if ($_GET['action'] == "mod") {
	if($_GET['id']){
		$tmp_info = $expo->read(null,intval($_GET['id']));
		if(!empty($fair_companies)){
			$fair_companies = unserialize($tmp_info['ExpoEw']);
			setvar("FairCompanies", implode(",", $fair_companies));
		}
		setvar("one",$tmp_info);
	}
	editor("Expo[el]", $tmp_info['ExpoEl'], "FCK_EXPOEL");
	$tpl_file = "fair_edit";
}else {
	$amount = $expo->findCount();
	pageft($amount,$display_eve_page);
	$fields = "Expo.id as ExpoId,Expo.ea as ExpoTitle,Expo.status as ExpoStatus,Expo.ef ExpoStartDate,Expo.eg as ExpoEndDate,Expo.type_id as ExpoTypeId";
	$result = $expo->findAll($fields,null," Expo.id desc",$firstcount,$displaypg);
	setvar("Lists",$result);
	setvar("Amount",$amount);
	setvar("PageHeader",$page_header);
	setvar("ByPages",$pagenav);
}

template($tpl_file);
?>