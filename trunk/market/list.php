<?php
$inc_path = "../";
$li = 6;
require($inc_path."global.php");
uses("area","market","trade","industry");
require(SITE_ROOT.'./app/include/page.php');
$area = new Areas();
$trade = new Trades();
$market = new Markets();
$industry = new Industries();
if(isset($_GET['filter'])){
	$pos = strrpos($_GET['filter'], "code");
	$pieces = explode(",", $_GET['filter']);
	if(!$pos){
		$area_code_id = $area->find($pieces[2], "code_id", "id");
		$area_id = $pieces[2];
	}else{
		$area_code_id = $pieces[2];
		$area_id = $area->find($area_code_id, "id", "code_id");
	}
	if($pieces[0]=="province"){
		$conditions.= " and Market.province_id=".$area_code_id;
	}elseif($pieces[0]=="city"){
		$conditions.= " and Market.city_id=".$area_code_id;
	}
}
if(!empty($_GET['industryid'])) {
	$conditions.= " and Market.industry_id=".intval($_GET['industryid']);
}
if($area_code_id){
	$_areaname = $area->field("name", "code_id=".$area_code_id);
	setvar("AreaName",$_areaname);
	$sub_areas = $area->getSubAreaById($area_id);
	$_titles[] = $_areaname;
	$_positions[] = $_areaname;
}
$province_name = $sub_areas[0]['name'];
if (!empty($province_name)) {
    $_titles[] = $province_name;
    $_positions[] = $province_name;
}
if(is_array($sub_areas)) array_shift($sub_areas);
uaAssign(array("SubAreas"=>$sub_areas,"ProvinceName"=>$province_name));
$table['trade'] = $trade->getTable(true);
$fields = "Trade.id AS TradeId,Trade.topic AS TradeTopic,html_file_id AS HtmlFileId,type_id as TradeTypeId";
$sql = "select ".$fields." from ".$table['trade']." where Trade.status ='1' ORDER BY Trade.id DESC LIMIT 0,12";
$res = $g_db->GetAll($sql);
setvar("LatestTrades",$res);
$conditions.= " and Market.status=1";
if ($_GET['search']) {
	$s_key = $_GET['market']['keyword'];
	if($_GET['market']['keyword']) {
		$conditions.=" and Market.name like '%".$s_key."%'";
		$r_key = "<strong><font color=red>".$s_key."</font></strong>";
		uaAssign(array("SearchKey"=>$s_key, "ReplaceKey"=>$r_key));
		$_titles[] = $s_key;
		$_positions[] = $s_key;
	}
	if($_GET['industry_id']) $conditions.=" and Market.industry_id=".intval($_GET['industry_id']);
	if($_GET['province_id']) $conditions.=" and Market.province_id=".intval($_GET['province_id']);
}
if ($_GET['industry']) {
	$conditions.=" and Market.industry_id=".intval($_GET['industry']);
	$industry_name = $industry->field("name", "id=".intval($_GET['industry']));
	setvar("IndustryName", $industry_name);
	$_titles[] = $industry_name;
	$_positions[] = $industry_name;
}
$fields = "id as MarketId,name as MarketName,content as MarketContent,created as MarketCreated";
$amount = $market->findCount(" 1 ".$conditions);
pageft($amount,10);
$area_markets = $market->findAll($fields, " 1 ".$conditions, "Market.id DESC", $firstcount, $displaypg);
include("industry.inc.php");
setvar("TradeTypes", $trade->getTradeTypes());
setvar("TradeNames", $trade->getTradeTypeNames());
setvar("AreaMarkets", $area_markets);
$_titles[] = lgg("market_center");
$_positions[] = lgg("market_center");
$market->setPageTitle($_titles, $_positions);
uaAssign(array("pageTitle"=>$market->title, "pagePosition"=>$market->position));
setvar("ByPages",$pagenav);
template($theme_name."/market_list");
?>