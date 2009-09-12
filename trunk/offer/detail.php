<?php
$inc_path = "../";
$li = 0;
require($inc_path."global.php");
include(SITE_ROOT."./data/tmp/data/".$cookiepre."area.inc.php");
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
$pid = intval($_GET['id']);
if (isset($_POST['action']) && !empty($ua_user['id'])) {
    if (empty($ua_user)) {
        die("Login First!")    	;
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

$res = $g_db->GetRow($sql);
$member_id = $res['MemberId'];
$trade->checkAccess(serialize($res));
$trade->clicked($pid);
require($inc_path."product/fineproducts.php");
$trade->setTradeCat($res['trade_type']);
$tradetype = strtolower($trade->trade_cate);
$IfTradeOpen = intval($setting->field("valued","variable='".$tradetype."_logincheck'"));
setvar("IfTradeOpen", $IfTradeOpen);
$res['TradeExtends'] = unserialize($res['TradeExtends']);
if (!empty($res['keywords'])) {
	$tKeys = $g_db->GetArray("select title from {$tb_prefix}keywords where id in (".$res['keywords'].")");
	$rKeys = null;
	foreach ($tKeys as $val) {
		$rKeys.="<a href='".URL."tag.php?type=trades&keyword=".urlencode($val['title'])."' target='_blank'>".$val['title']."</a>&nbsp;";
	}
	$res['keywords'] = $rKeys;
}
$res['Description'] = preg_replace("/(\r?\n)\\1+/","\\1",$res['Description']);

$res['province_name'] = $UL_DBCACHE_AREAS[$res['TradeProvinceId']];
$res['city_name'] = $UL_DBCACHE_AREAS[$res['TradeCityId']];
setvar("tradeInfo",$res);
setvar("Li",$li);
if (isset($_GET['action']) && ($_GET['action'])=="html" && STATIC_HTML_LEVEL>1) {
	$file_path = '../htmls/trade/'.date("Y")."/".date("m")."/".date("d")."/";
	$html_file_name = $_GET['id'].'.html';
	if(!file_exists($file_path)){
		if(PHP_VERSION<5){
			createFolder($file_path,0777);
		}else{
			mkdir($file_path,0777,true);
		}
	}
	$cached = $smarty->MakeHtmlFile($file_path.$html_file_name,$smarty->fetch("trade/content.html"));
	if($cached){
		$g_db->execute("update ".$trade->getTable()." set html_file_id='$html_file_name' where id=".$pid);
	}
}
template($theme_name."/trade_content");
?>