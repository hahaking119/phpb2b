<?php
$inc_path = "../";
$li = 4;
require($inc_path."global.php");
uses("product","company","member","industry","area","memberlog");
$area = new Areas();
$memberlog = new Memberlogs();
$industry = new Industries();
$company = new Companies();
$member = new Members();
$product = new Products();
$tmp_status = explode(",",lgg('product_status'));
$smarty->register_function("format_keywords","SplitKeywords");
include(SITE_ROOT."./data/tmp/data/".$cookiepre."industry.inc.php");
$pid = intval($_GET['id']);
$fields = $product->industry_cols.",Product.status as ProductStatus,company_id";
$table['product'] = $product->getTable();
$table['area']	= $area->getTable();
$table['industry'] = $industry->getTable();
$sql = "select ".$fields." ,Member.username as MemberUsername from ".$product->getTable(true)." left join ".$member->getTable(true)." on Product.member_id=Member.id  where Product.state=1 and Product.id=".$pid;
$res = $g_db->GetRow($sql);
$member_id = $res['MemberId'];

$res['IndustryName'] = $UL_DBCACHE_INDUSTRIES[$res['IndustryID']];
if($res['ProductStatus']!=1){
	$tmp_key = intval($res['ProductStatus']);
	alert(urlencode(sprintf(lgg("record_status"),$res['Name'],$tmp_status[$tmp_key])));
}
if (!empty($res['ProductKeywords'])) {
	$_tags = $g_db->GetArray("select title as ItemTitle from ".$tb_prefix."keywords where id in (".trim($res['ProductKeywords']).")");
	$_assigns['ProductKeywords'] = $_tags;
}
$sql = "SELECT Company.id AS CompanyId,Company.name AS CompanyName,Company.link_man AS CompanyLinkMan,CONCAT(telcode,'-',telzone,'-',tel) AS CompanyTel,AreaProvince.name as AreaProvinceName,AreaCity.name as AreaCityName FROM ".$company->getTable(true)." left join ".$table['area']." as AreaProvince on Company.province_code_id=AreaProvince.code_id left join ".$table['area']." as AreaCity on Company.city_code_id=AreaCity.code_id WHERE Company.id=".$res['company_id'];
$company_res = $g_db->GetRow($sql);
$trade_info['CompanyID'] = $company_res['CompanyId'];
$trade_info['CompanyName'] = $company_res['CompanyName'];
$trade_info['CompanyLinkMan'] = $company_res['CompanyLinkMan'];
$trade_info['CompTel'] = $company_res['CompanyTel'];
$trade_info['AreaZone'] = $company_res['AreaProvinceName'].$company_res['AreaCityName'];
$trade_info['OfferUserName'] = $res['MemberUsername'];
$_assigns["tradeInfo"] = $trade_info;
require("./fineproducts.php");
$_assigns["prodInfo"] = $res;
uaAssign($_assigns);
unset($res, $trade_info);
$product->clicked($pid);
template($theme_name."/product_content");
?>