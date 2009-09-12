<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './app/configs/db_session.php');
require("session_cp.inc.php");
require(SITE_ROOT.'./app/include/page.php');
uses("keywordship", "company", "product", "trade","keyword");
$keywordship = new Keywordships();
$keyword = new Keywords();
$company = new Companies();
$product = new Products();
$trade = new Trades();
$tpl_file = "keywordship_index";

if ($_GET['action'] == "mod") {
	setvar("Priors", $keywordship->priorities);
	if (!empty($_GET['id'])) {
		$result = $keywordship->read(null, $_GET['id']);
		setvar("info",$result);
	}
	$tpl_file = "keywordship_edit";
}
if (isset($_POST['kf'])) {
	$prior_action = $_POST['kf'];
	if (!empty($_POST['id'])) {
		$ids = implode(",",$_POST['id']);
		if (isset($prior_action['u'])) {
			$sql = "update ".$keywordship->getTable()." set kf=kf+1 where id in (".$ids.")";
		}elseif (isset($prior_action['d'])){
			$sql = "update ".$keywordship->getTable()." set kf=kf-1 where id in (".$ids.")";
		}
		$result = $g_db->Execute($sql);
	}
}
if($_GET['action']=="list"){
	$amount = $keywordship->findCount();
	pageft($amount,$display_eve_page);
	$fields = "Keyword.title as KeywordTitle,ka as TradeId,kb as CompanyId,kc as ProductId,kd as MarketId,ke as KeywordId,kg as StartDate,kh as EndDate,kf as Priority,Product.name as ProductName,Trade.topic as TradeTopic,Company.name as CompanyName";
	$sql = "select ".$fields." from ".$keywordship->getTable(true)." left join ".$keyword->getTable(true)." on Keywordship.ke=Keyword.id left join ".$trade->getTable(true)." on Keywordship.ka=Trade.id left join ".$product->getTable(true)." on Keywordship.kc=Product.id left join ".$company->getTable(true)." on Keywordship.kb=Company.id where 1 limit $firstcount,$displaypg";
	$result = $g_db->GetAll($sql);
	setvar("Lists",$result);
	unset($result);
	uaAssign(array("Amount"=>$amount,"PageHeader"=>$page_header,"ByPages"=>$pagenav));
}
//:~
template($tpl_file);
?>