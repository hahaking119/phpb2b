<?php
$inc_path = "../";$ua_sm_compile_dir = "room/";
require($inc_path."global.php");
require("session.php");
uaCheckPermission(2);
uses("member","industry","company","access","area", "attachment");
$access = new Accesses();
$attachment = new Attachments();
$area = new Areas();
$industry = new Industries();
$member = new Members();
$company = new Companies();
$tpl_file = "company";
$company_id = $company->field("id","member_id=".$_SESSION['MemberID']);
if(!empty($company_id)){
	$company->primaryKey = "id";
	$fields = $company->getFieldAliasNames();
	$fields.= ",".$company->alias_cols;
	$res = $company->read($fields, $company_id, null," and Company.member_id=".$_SESSION['MemberID']);
	$res['ProvinceName'] = $area->field("name", "code_id=".intval($res['CompanyProvinceCodeId']));
	$res['CityName'] = $area->field("name", "code_id=".intval($res['CompanyCityCodeId']));
}
if (isset($_POST['edit_company'])) {
	require($inc_path .APP_NAME. 'include/inc.topinyin.php');
	$vals = array();
	if($res['CompanyStatus']==0){
		$vals['name'] = strip_tags($_POST['name']);
		$vals['english_name'] = strip_tags($_POST['english_name']);
		$vals['first_letter'] = getFirstPin($vals['name']);
	}
	if (isset($_POST['cindustry'])) {
		$industryid = $_POST['cindustry'];
	}else if(isset($_POST['bindustry'])){
		$industryid = $_POST['bindustry'];
	}else if(isset($_POST['aindustry'])){
		$industryid = $_POST['aindustry'];
	}
	if(!empty($industryid))
	$vals['industry_id'] = $industryid;
	$vals['employee_amount'] = $_POST['EmployeeAmount'];
	if($_POST['FoundDate']!="None") $vals['found_date'] = uaDateConvert($_POST['FoundDate']);
	$vals['year_annual'] = $_POST['AnnualRevenue'];
	if(isset($_POST['manage_type']))
	{
		$managetype = implode(",",$_POST['manage_type']);
		$vals['manage_type'] = $managetype;
	}
	$vals['property'] = $_POST['company_property'];
	$vals['main_prod'] = strip_tags($_POST['main_prod']);
	$vals['address'] = strip_tags($_POST['address']);
	$vals['description'] = strip_tags(trim($_POST['company_des']));
	$vals['boss_name'] = $_POST['bossname'];
	$vals['reg_address'] = $_POST['reg_address'];
	$vals['reg_fund'] = $_POST['reg_fund'];
	$vals['bank_from'] = $_POST['bank_from'];
	$vals['bank_account'] = $_POST['bank_account'];
	$vals['main_brand'] = $_POST['main_brand'];
	$vals['year_annual'] = $_POST['AnnualRevenue'];
	$vals['main_customer'] = $_POST['main_customer'];
	$vals['main_biz_place'] = $_POST['main_biz_place'];
	$vals['link_man'] = $_POST['linkman'];
	$vals['position'] = $_POST['position'];
	$vals['telcode'] = $_POST['telcode'];
	$vals['telzone'] = $_POST['telzone'];
	$vals['tel'] = $_POST['tel'];
	$vals['faxcode'] = $_POST['faxcode'];
	$vals['faxzone'] = $_POST['faxzone'];
	$vals['fax'] = $_POST['fax'];
	$vals['mobile'] = $_POST['mobile'];
	$vals['site_url'] = $_POST['site_url'];
	$vals['email'] = $_POST['email'];
	if(isset($_POST['provinceid'])) $vals['city_code_id'] = $_POST['provinceid'];
	if(isset($_POST['countryid'])) $vals['province_code_id'] = $_POST['countryid'];
	if(isset($_POST['main_market'])) {
		$mainmarket = implode(",",$_POST['main_market']);
		$vals['main_market'] = $mainmarket;
	}
	if (!empty($_FILES['picture']['name'])) {
	    include("../app/include/class.thumb.php");
	    $attachment->upload_form_field = "picture";
	    $attachment->out_file_dir     = BASE_DIR.'attachment/'.gmdate("Ym");
	    $attachment->out_file_name = $_SESSION['MemberID']."_logo_".$_SESSION['MemberID'];
	    $attachment->upload_process();
	    if ( $attachment->error_no )
	    {
	        flash("./tip.php","./company.php", lgg("upload_error").$attachment->error_no,0);
	    }
	    $img = new Image($attachment->saved_upload_name, $attachment->saved_upload_name, array("size"=>"10000"));
	    $vals['picture'] = gmdate("Ym")."/".$attachment->parsed_file_name;
	}
	$check_company_update = $access->field("check_company_update","membertype_id=".$ua_user['user_type']);
	if ($check_company_update==0) {
		$vals['status'] = 1;
		$message_info = lgg('action_complete');
	}else {
		$vals['status'] = 0;
		$message_info = lgg('msg_wait_check');
	}
	array_walk($vals,"uatrim");

	if(!empty($company_id)){
		$vals['modified'] = $time_stamp;
		$company->save($vals, "update", $company_id, null, " and member_id=".$_SESSION['MemberID']);
	} else {
		$vals['member_id'] = $_SESSION['MemberID'];
		$vals['created'] = $time_stamp;
		$company->save($vals);
		$last_company_id = $g_db->Insert_ID();
	}
	flash("./tip.php","./company.php",$message_info);
}
if(!empty($res)){
	if(!empty($res['CompanyIndustryId'])) $current_industry = $industry->searchParentIndustry($res['CompanyIndustryId']);
	if (is_array($current_industry)) {
		$search_industry_ids = implode(",",$current_industry);
		setvar("CurrentIndustry",$g_db->GetArray("SELECT name AS IndustryName FROM ".$industry->getTable()." WHERE id in (".$search_industry_ids.")"));
	}
}
setvar("CompanyInfo",$res);
setvar("CompanyProperty",$company->economic_type);
$selected['property'] = $res['CompanyProperty'];
setvar("SelectedType",$selected['property']);
setvar("ManageTypes",$company->manage_type);
$selected['properties'] = explode(",",$res['CompanyManageType']);
setvar("SelectedProperty",$selected['properties']);
setvar("MainMarkets",$company->main_market);
$selected['markets'] = explode(",",$res['CompanyMainMarket']);
setvar("SelectedMarket",$selected['markets']);
setvar("CompanyFunds",$company->company_funds);
$selected['fund'] = $res['CompanyRegFund'];
setvar("SelectedFund",$selected['fund']);
setvar("CompanyAnual",$company->year_annuals);
$selected['annual'] = $res['CompanyYearAnnual'];
setvar("SelectedAnual",$selected['annual']);
setvar("LinkmanPositions",$member->ua_positions);
setvar("SelectedPosition",$res['CompanyPosition']);
setvar("EmployeeAmounts",$company->employee_amount);
setvar("SelectedEmployeeAmount",$res['CompanyEmployeeAmount']);
unset($selected,$res);
template($office_theme_name."/".$tpl_file);
?>