<?php
$inc_path = "../";
$li = 0;
require($inc_path."global.php");
include(SITE_ROOT."./data/cache/".$cookiepre."area.inc.php");
require(SITE_ROOT. './libraries/breadcrumb.inc.php');
$positions = $titles = array();
uses("trade","product","member","company","memberlog","industry","area","setting", "offer");
$area = new Areas();
$offer = new Offers();
$industry = new Industries();
$company = new Companies();
$product = new Products();
$trade = new Trades();
$member = new Members();
$tmp_status = explode(",",lgg('product_status'));
$setting = new Settings();
setvar("ObjectParams", $trade->params);
setvar("Genders", $member->genders);
setvar("PhoneTypes", $member->phone_types);
$viewhelper->setTitle('供应&reg;');
$viewhelper->setPosition('网站首页', URL, 1);
$viewhelper->setPosition('供应', URL.'seller/index.php', 2);
//$viewhelper->setPosition('供应', 'list.php', 3, array('type'=>'sell'));
$pid = intval($_GET['id']);
if (isset($_POST['action']) && !empty($ua_user['id'])) {
    if (empty($ua_user)) {
        die(L('please_login_first'))    	;
    }
	if ($_POST['action']=="favor" && !empty($_POST['id'])) {
		$sql = "insert into {$tb_prefix}favorites (member_id,target_id,type_id,created) values (".$ua_user['id'].",".intval($_POST['id']).",".intval($_POST['type_id']).",".$time_stamp.");";
		$g_db->Execute($sql);
	}
	exit;
}
if(!empty($_GET['title'])){
	$trade_title = urldecode(trim($_GET['title']));
	$pid = $trade->field("id", "topic='".$trade_title."'");
}
$fields = "Offer.oa as TradeExtends,Offer.user_name as OfferUserName,Offer.company_name as CompanyName,Offer.province_name,Offer.industry_name as IndustryName, Offer.country_name,Offer.city_name,Offer.link_man as CompanyLinkMan,Offer.gender as OfferGender,Offer.prim_telnumber as CompTel,Offer.prim_tel as TelType,Trade.id AS TID,Trade.industry_id as IndustryId,Trade.id AS TradeId,topic AS Name,content AS Description,company_id AS CompanyID,Trade.member_id as MemberId,Trade.picture AS TradePicture,Trade.area_id as TradeProvinceId,Trade.province_id as TradeCityId,Trade.status AS TradeStatus,Trade.type_id AS trade_type,Trade.submit_time AS PublishDate,expire_time AS ExpireDate,require_membertype,require_point,keywords";
$sql = "select ".$fields." from ".$offer->getTable(true)." right join ".$trade->getTable(true)." on  Offer.trade_id=Trade.id where Trade.id=".$pid;
//取得供求的详细资料
$offer_detail = $g_db->GetRow($sql);
$member_id = $offer_detail['MemberId'];
$trade->checkAccess(serialize($offer_detail));
$trade->clicked($pid);
require($inc_path."product/fineproducts.php");
$trade->setTradeCat($offer_detail['trade_type']);
$tradetype = strtolower($trade->trade_cate);
$IfTradeOpen = intval($setting->field("valued","variable='".$tradetype."_logincheck'"));
setvar("IfTradeOpen", $IfTradeOpen);
$offer_detail['TradeExtends'] = unserialize($offer_detail['TradeExtends']);
if (!empty($offer_detail['keywords'])) {
	$tKeys = $g_db->GetArray("select title from {$tb_prefix}keywords where id in (".$offer_detail['keywords'].")");
	$rKeys = null;
	foreach ($tKeys as $val) {
		$rKeys.="<a href='".URL."tag.php?type=trades&keyword=".urlencode($val['title'])."' target='_blank'>".$val['title']."</a>&nbsp;";
	}
	$offer_detail['keywords'] = $rKeys;
}
$offer_detail['Description'] = preg_replace("/(\r?\n)\\1+/","\\1",$offer_detail['Description']);
if (isset($UL_DBCACHE_AREAS[$offer_detail['TradeProvinceId']])) {
	$offer_detail['province_name'] = $UL_DBCACHE_AREAS[$offer_detail['TradeProvinceId']];
}else{
    $offer_detail['province_name'] = L('unknown', 'tpl');
}
if (isset($UL_DBCACHE_AREAS[$offer_detail['TradeCityId']])) {
    $offer_detail['city_name'] = $UL_DBCACHE_AREAS[$offer_detail['TradeCityId']];
}else{
    $offer_detail['city_name'] = L('unknown', 'tpl');
}
$offer_detail['PublishDate'] = date("Y-m-d", $offer_detail['PublishDate']);
$offer_detail['ExpireDate'] = date("Y-m-d", $offer_detail['ExpireDate']);
if (!empty($offer_detail['TradePicture'])) {
	$offer_detail['picture'] = URL."attachment/".$offer_detail['TradePicture'];
}else{
    $offer_detail['picture'] = URL."images/nopic.large.jpg";
}
setvar("offer",$offer_detail);
setvar("Li",$li);
$viewhelper->setTitle($offer_detail['Name'].'[有图片]');
$viewhelper->setPosition($offer_detail['Name'], null, 4);
uaAssign(array(
"current_position"=>$viewhelper->getPosition(" &raquo; "),
"page_title"=>$viewhelper->getTitle(" - ")
));
template($theme_name."/trade_content");
?>