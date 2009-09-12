<?php
$inc_path = "../";$ua_sm_compile_dir = "room/";
require($inc_path."global.php");
require("session.php");
uses("member","area", "attachment");
$member = new Members();
$attachment = new Attachments();
$area = new Areas();
$conditions = null;
if ($_POST['save']) {
	$vals = array();
	$vals = $_POST['member'];
	$vals['province_code_id'] = $_POST['provinceid'];
	$vals['city_code_id'] = $_POST['cityid'];
	array_walk($vals,"uatrim");
	if (!empty($_FILES['photo']['name'])) {
	    include("../app/include/class.thumb.php");
	    $attachment->upload_form_field = "photo";
	    $attachment->out_file_dir     = BASE_DIR.'attachment/'.gmdate("Ym");
	    $attachment->out_file_name = "photo_".$_SESSION['MemberID'];
		$attach['title'] = $_POST['member']['lastname'];
		$attach['description'] = $_POST['member']['lastname'];
		$attach['type_id'] = 10;
	    $attachment->upload_process();
	    if ( $attachment->error_no )
	    {
	        flash("./tip.php","./personal.php", lgg("upload_error").$attachment->error_no,0);
	    }
	    $img = new Image($attachment->saved_upload_name, $attachment->saved_upload_name);
	    $img->Thumb(116, 150);
	    $vals['photo'] = gmdate("Ym")."/".$attachment->parsed_file_name;
	}
	$result = $member->save($vals, "update", $_SESSION['MemberID']);
	if(!$result){
		flash("./tip.php",null, lgg('not_defined_error'),0);
	}else{
		flash("./tip.php", null, lgg('action_complete'), 1);
	}
}
$fields = "Member.ID AS MemberId,resume_status as ResumeStatus,photo as PersonalPhoto,USERNAME AS MemberUsername,USERPASS AS MemberUserpass,FIRSTNAME AS MemberFirstname,LASTNAME AS MemberLastname,DEPART AS MemberDepart,GENDER AS MemberGender,TEL AS MemberTel,FAX AS MemberFax,MOBILE AS MemberMobile,QQ AS MemberQq,MSN AS MemberMsn,ICQ AS MemberIcq,YAHOO AS MemberYahoo,ADDRESS AS MemberAddress,ZIPCODE AS MemberZipcode,EMAIL AS MemberEmail,SITE_URL AS MemberSiteUrl,AreaProvince.name AS MemberProvince,AreaCity.name AS MemberCity,Member.office_redirect as MemberOfficeRedirect";
$sql = "SELECT ".$fields." FROM ".$member->getTable(true)." LEFT JOIN ".$area->getTable()." AS AreaProvince ON Member.province_code_id=AreaProvince.code_id LEFT JOIN ".$area->getTable()." AS AreaCity ON Member.city_code_id=AreaCity.code_id WHERE Member.id=".$_SESSION['MemberID'];
$info = $g_db->GetRow($sql);
setvar("Genders",$member->genders);
unset($member->educations[0]);
setvar("Educations",$member->educations);
setvar("OfficeRedirects", $member->office_redirects);
setvar("p",$info);
template("personal");
?>