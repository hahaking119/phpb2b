<?php
if(!defined('IN_UALINK')) exit('Access Denied');
uses("area");
$area = new Areas();
setvar("Genders",$member->genders);
$fields = "Company.link_man AS CompanyLinkMan,Company.email AS CompanyEmail,Company.mobile AS CompanyMobile,link_man_gender AS LinkManGender,Company.telcode,Company.telzone,Company.tel,Company.faxcode,Company.faxzone,Company.fax,Company.address AS CompanyAddress,Company.zipcode AS CompanyZipcode,Company.site_url AS CompanySiteUrl";
$company_info = $company->read($fields,$companyinfo['ID']);
if (empty($company_info)) {
	alert(lgg("record_not_exists"), $companyinfo['ID']);
}else {
	$company_info['CompanyTel'] = $company_info['telcode']."-".$company_info['telzone']."-".$company_info['tel'];
	$company_info['CompanyFax'] = $company_info['faxcode']."-".$company_info['faxzone']."-".$company_info['fax'];
	setvar("CompanyInfo",$company_info);
}
template("../skins/".$tplpath."contact");
?>