<?php
$inc_path = "../";$ua_sm_compile_dir = "room/";
require($inc_path."global.php");
require("session.php");
uses("member","area");
$member = new Members();
$area = new Areas();
$conditions = null;
if ($_POST['save']) {
	$vals = array();
	$vals = $_POST['member'];
	$vals['province_code_id'] = $_POST['provinceid'];
	$vals['city_code_id'] = $_POST['cityid'];
	array_walk($vals,"uatrim");
	$result = $member->save($vals, "update", $_SESSION['MemberID']);
	if(!$result){
		flash("./tip.php",null, lgg('not_defined_error'),0);
	}else{
		flash("./tip.php", null, lgg('action_complete'), 1);
	}
}
$fields = "Member.ID AS MemberId,USERNAME AS MemberUsername,USERPASS AS MemberUserpass,FIRSTNAME AS MemberFirstname,LASTNAME AS MemberLastname,DEPART AS MemberDepart,GENDER AS MemberGender,TEL AS MemberTel,FAX AS MemberFax,MOBILE AS MemberMobile,QQ AS MemberQq,MSN AS MemberMsn,ICQ AS MemberIcq,YAHOO AS MemberYahoo,ADDRESS AS MemberAddress,ZIPCODE AS MemberZipcode,EMAIL AS MemberEmail,SITE_URL AS MemberSiteUrl,AreaProvince.name AS MemberProvince,AreaCity.name AS MemberCity,Member.office_redirect as MemberOfficeRedirect";
$sql = "SELECT ".$fields." FROM ".$member->getTable(true)." LEFT JOIN ".$area->getTable()." AS AreaProvince ON Member.province_code_id=AreaProvince.code_id LEFT JOIN ".$area->getTable()." AS AreaCity ON Member.city_code_id=AreaCity.code_id WHERE Member.id=".$_SESSION['MemberID'];
$info = $g_db->GetRow($sql);
setvar("Genders",$member->genders);
setvar("OfficeRedirects", $member->office_redirects);
setvar("p",$info);
template($office_theme_name."/"."personal");
?>