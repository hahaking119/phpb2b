<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './app/configs/db_session.php');
require(LIB_PATH .'time.class.php');
require("session_cp.inc.php");
uses("adzone","ad","member","attachment");
require(SITE_ROOT.'./libraries/page.php');
$tpl_file = "ad_index";
$attachment = new Attachments();
$adzone = new Adzones();
$ads = new Adses();
$member = new Members();
$conditions = null;
setvar("AdsStatus", explode(",",lgg('yes_no')));
setvar("AdsPopTargets",$ads->pop_target);
setvar("Adzones",$adzone->findAll("id,name",null,"id desc",0,100));
if (isset($_POST['save'])) {
	$vals = $_POST['ad'];
	if((!$vals['source_url']) || empty($vals['source_url'])){
		if (!empty($_FILES['pic']['name'])) {
			include("../libraries/class.thumb.php");
			$attachment->out_file_dir     = BASE_DIR.'attachment/'.gmdate("Ym");
			$attachment->out_file_name = $time_stamp;
			$attachment->upload_process();
			if ( $attachment->error_no )
			{
				flash("./alert.php","./ad.php", "上传失败: ".$attachment->error_no,0);
			}
			//$img = new Image($attachment->saved_upload_name, $attachment->saved_upload_name);
			//$img->Thumb();
			//$attachment->imageWaterMark($attachment->saved_upload_name, "../images/watermark.png");
			//$vals['picture'] = gmdate("Ym")."/".$attachment->parsed_file_name;
			$vals['source_name'] = gmdate("Ym")."/".$attachment->parsed_file_name;
			$vals['source_url'] = URL."attachment/".$vals['source_name'];
		}
	}else{
		$t_sourceurl = explode("/", $vals['source_url']);
		$vals['source_name'] = $t_sourceurl[count($t_sourceurl)-1];
	}
	if (!empty($_POST['member']['id'])){
		$vals['member_id'] = $_POST['member']['id'];
	}elseif(!empty($_POST['member']['username'])) {
		$member_id = $member->field("id","username='".trim($_POST['member']['username'])."'");
		$vals['member_id'] = $member_id;
	}
	if($_POST['ServiceFromDate']!="None") {
	    $vals['start_date'] = Times::dateConvert($_POST['ServiceFromDate']);
	}
	if($_POST['ServiceEndDate']!="None") {
	    $vals['end_date'] = Times::dateConvert($_POST['ServiceEndDate']);
	}
	$zone_id = $_POST['id'];
	if (!empty($zone_id)) {
		$result = $ads->save($vals, "update", $zone_id);
	}else{
		$vals['created'] = $time_stamp;
		$result = $ads->save($vals);
	}
	if (!$result) {
		flash("./alert.php", "./ad.php", lgg('save_false'),0, null);
	}else{
		flash("./alert.php","./ad.php");
	}
}
if (isset($_POST['del']) && !empty($_POST['id'])) {
	$result = $ads->del($_POST['id']);
}
if ($_GET['action']=="del" && !empty($_GET['id'])) {
	$result = $ads->del($_GET['id'])	;
}
if ($_GET['action'] == "mod") {
	setvar("AdTypes",$ads->types);
	if (!empty($_GET['id'])) {
		$result = $ads->read("*", $_GET['id']);
		setvar("a",$result);
	}
	$tpl_file = "ad_edit";
}else{
	$amount = $ads->findCount();
	pageft($amount, $display_eve_page);
	$joins = array(
	"Member"=>array("fullTableName"=>$member->getTable(true),"foreignKey"=>"member_id","fields"=>"Member.username as MemberUserName"),
	"Adzone"=>array("fullTableName"=>$adzone->getTable(true),"foreignKey"=>"adzone_id","fields"=>"Adzone.name as AdzoneName,Adzone.file_name as AdzoneFileName")
	);
	$result = $ads->findAll("Ads.clicked,Ads.member_id,Ads.id,Ads.title,Ads.status,start_date,end_date",$conditions, " Ads.id desc", $firstcount, $displaypg);
	setvar("Lists",$result);
	unset($joins);
	uaAssign(array("Amount"=>$amount,"PageHeader"=>$page_header,"ByPages"=>$pagenav));
}

template($tpl_file);
?>