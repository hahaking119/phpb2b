<?php
$inc_path = "../";$ua_sm_compile_dir = "office-room/";
require($inc_path."global.php");
require("session.php");
uaCheckPermission(2);
uses("member","industry","company");
$industry = new Industries();
$member = new Members();
$company = new Companies();
$company->primaryKey = "member_id";
$tpl_file = "card";
$company_id = $company->find($_SESSION['MemberID']);
setvar("CompanId", $company_id);
if ($_POST['save']) {
	$vals = array();
	$vals['link_man'] = $_POST['company']['link_man'];
	$vals['tel'] = $_POST['company']['tel'];
	$vals['telzone'] = $_POST['company']['telzone'];
	$vals['telcode'] = $_POST['company']['telcode'];
	$vals['fax'] = $_POST['company']['fax'];
	$vals['faxzone'] = $_POST['company']['faxzone'];
	$vals['faxcode'] = $_POST['company']['faxcode'];
	$vals['name'] = strip_tags($_POST['company']['name']);
	$vals['mobile'] = strip_tags($_POST['company']['mobile']);
	$vals['email'] = $_POST['company']['email'];
	$company->primaryKey = "id";
	$result = $company->save($vals, "update", $company_id);
	if($result){
		flash("./tip.php");
	}else{
		flash("./tip.php",null,null,0);
	}
}
if(!empty($company_id)){
	$company->primaryKey = "id";
	$fields = "Company.id AS CompanyId,Company.name AS CompanyName,Company.link_man AS CompanyLinkMan,Company.mobile AS CompanyMobile,Company.telcode AS CompanyTelcode,Company.telzone AS CompanyTelzone,Company.tel AS CompanyTel,Company.faxcode AS CompanyFaxcode,Company.faxzone AS CompanyFaxzone,Company.fax AS CompanyFax,Company.address AS CompanyAddress,Company.zipcode AS CompanyZipcode,Company.email AS CompanyEmail";
$res = $company->read($fields,$company_id,null," AND Company.member_id=".$_SESSION['MemberID']);
setvar("CompanyInfo",$res);
}else{
	setvar("CompanyNotExists", lgg('company_not_exists'));
}
template($tpl_file);
?>