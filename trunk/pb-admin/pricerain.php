<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './app/configs/db_session.php');
require(SOURCE_PATH .'xajax/xajax.inc.php');
uses("pricerain", "price", "market");
require(SITE_ROOT.'./libraries/page.php');
require("session_cp.inc.php");
$market = new Markets();
$pricerain = new Pricerains();
$price = new Prices();
$tpl_file = "pricerain_index";
$xajax = new xajax();
function updatePriceName($id, $type, $value)
{
	global $g_db;
	global $price;
	$obj = new xajaxResponse();
	$numargs = func_num_args();
	switch ($type) {
		case "name":
			$u = "name='".$value."'";
			break;
		case "max_price":
			$u = "max_price='".$value."'";
			break;
		case "min_price":
			$u = "min_price='".$value."'";
			break;
		default:
			break;
	}
	$result = $g_db->Execute("update ".$price->getTable()." set ".$u." where id=".$id);
	if($result) {
		$obj->addAssign("updateResult_".$id, "innerHTML", "<img src='images/right.gif' border='0' />");
	}
	return $obj->getXML();
}
$xajax->registerFunction("updatePriceName");
require($inc_path.APP_NAME."include/ajax.inc.php");
if (isset($_POST['save'])) {
	$vals = $_POST['pricerain'];
	if (!empty($_POST['pricerain']['id'])) {
		$vals['modified'] = $time_stamp;
		$pricerain_id = intval($_POST['pricerain']['id']);
		$pricerain->save($vals, "update", $pricerain_id);
	}else{
		$vals['created'] = $time_stamp;
		$pricerain->save($vals);
		$pricerain_id = $pricerain->getMaxId()+1;
	}
	if (!empty($_POST['PriceName'])) {
		$sql = "insert into ".$price->getTable()." (name,max_price,min_price,av_price,created,pricerain_id) values ";
		$max_es = $_POST['MaxPrice'];
		$min_es = $_POST['MinPrice'];
		$v = null;
		foreach ($_POST['PriceName'] as $key=>$price_name) {
			if(!empty($price_name)) $v[] = "('".$price_name."','".$max_es[$key]."','".$min_es[$key]."','".round(($max_es[$key]+$min_es[$key])/2)."',".$time_stamp.",".$pricerain_id.")";
		}
		if(is_array($v)) $v_s = implode(",", $v);
		$sql.=$v_s;
	}
	flash("alert.php", "pricerain.php?action=list");
}
if ($_GET['action'] == "mod") {
	setvar("MoneyTypes", $pricerain->money_types);
	setvar("Units", $pricerain->units);
	if (isset($_GET['pricerain_id'])) {
		//get rain info.
		$raind_id = $_GET['pricerain_id'];
		$rain_info = $pricerain->read(null, $raind_id);
		setvar("RainInfo", $rain_info);
		//get all prices.
		$rain_prices = $price->findAll(null, "pricerain_id=".$raind_id);
		setvar("RainPrice", $rain_prices);
	}
	$tpl_file = "pricerain_edit";
}
if ($_GET['action'] == "list") {
	$fields = "Pricerain.title as RainTitle,Pricerain.id as RainId,Pricerain.created as RainCreate";
	$amount = $pricerain->findCount();
$joins = array(
	"Market"=>array("fullTableName"=>$market->getTable(true),"foreignKey"=>"market_id","fields"=>"Market.name AS MarketName")
	);
pageft($amount,$display_eve_page);
	$rains = $pricerain->findAll($fields, null, "Pricerain.id desc", $firstcount, $displaypg);
	setvar("Lists", $rains);
	uaAssign(array("Amount"=>$amount,"PageHeader"=>$page_header,"ByPages"=>$pagenav));
}
template($tpl_file);
?>