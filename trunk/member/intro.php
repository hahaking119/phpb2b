<?php
if(!defined('IN_UALINK')) exit('Access Denied');
$company_info = $company->read("*",$companyinfo['ID']);
foreach (explode(",",$company_info['main_market']) as $market) {
	$main_markets .= $company->main_market[$market]."&nbsp;&nbsp;";
}
foreach (explode(",",$company_info['manage_type']) as $m_type) {
	$manage_types .= $company->manage_type[$m_type]."&nbsp;&nbsp;";
}
$company_info['manage_type'] = $manage_types;
$company_info['main_market'] = $main_markets;
$company_info['ecnomy'] = $company->economic_type[$company_info['property']];
$company_info['reg_fund'] = $company->company_funds[$company_info['reg_fund']];
$company_info['year_annual'] = $company->year_annuals[$company_info['year_annual']];

setvar("CompanyInfo",$company_info);
unset($company_info);
template($tplpath."introduction");
?>