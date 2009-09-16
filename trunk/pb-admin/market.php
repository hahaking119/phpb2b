<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './app/configs/db_session.php');
uses("market","area","industry", "attachment");
require(SITE_ROOT.'./libraries/page.php');
require("session_cp.inc.php");
$attachment = new Attachments();
$market = new Markets();
$area = new Areas();
$industry = new Industries();
$conditions = null;
$table['market'] = $market->getTable(true);
$table['area'] = $area->getTable();
$table['industry'] = $industry->getTable(true);

$tpl_file = "market_index";
if ($_GET['action'] == "del" && !empty($_GET['id'])) {
	$market->del($_GET['id']);
}
if (isset($_POST['del']) && !empty($_POST['id'])) {
	$market->del($_POST['id']);
}
if (isset($_POST['check']) && !empty($_POST['id'])) {
	$ids = implode(",", $_POST['id']);
	$condition = " id in (".$ids.")";
	$sql = "update ".$market->getTable()." set status=1 where ".$condition;
	$result = $g_db->Execute($sql);
}
if (isset($_POST['uncheck']) && !empty($_POST['id'])) {
	$ids = implode(",", $_POST['id']);
	$condition = " id in (".$ids.")";
	$sql = "update ".$market->getTable()." set status=0 where ".$condition;
	$result = $g_db->Execute($sql);
}
if (isset($_POST['save']) && !empty($_POST['market'])) {
	$vals = array();
	$vals = $_POST['market'];
	if(isset($_POST['market_industry_id'])){
		$vals['industry_id'] = $_POST['market_industry_id'];
	}
	if(isset($_POST['cityid'])){
		$vals['city_id'] = $_POST['cityid'];
	}
	if (isset($_POST['provinceid'])) {
		$vals['province_id'] = $_POST['provinceid'];
	}
	if(isset($_POST['cityid'])){
		$vals['area_id'] = $_POST['cityid'];
	}elseif (isset($_POST['provinceid'])) {
		$vals['area_id'] = $_POST['provinceid'];
	}
	if (!empty($_FILES['pic']['name'])) {
        include("../libraries/class.thumb.php");
		ini_set("memory_limit", "32M");
        $attachment->out_file_dir     = BASE_DIR.'./attachment/'.gmdate("Ym");
        $attachment->out_file_name = $time_stamp;
        $attachment->upload_process();
        if ( $attachment->error_no )
        {
            flash("./alert.php","./market.php", lgg("upload_error").$attachment->error_no,0);
        }
        $img = new Image($attachment->saved_upload_name, $attachment->saved_upload_name);
        $img->Thumb();
        //$attachment->imageWaterMark($attachment->saved_upload_name, "../images/watermark.png");
        $vals['picture'] = gmdate("Ym")."/".$attachment->parsed_file_name;
	}
	array_walk($vals, "uatrim");
	$mid = intval($_POST['id']);
	if ($mid) {
		$result = $market->save($vals, "update", $mid);
	}else {
		$vals['created'] = $time_stamp;
		$result = $market->save($vals);
	}
	if($result){
		flash("./alert.php","./market.php");
	}else{
		flash("./alert.php","./market.php",null,0);
	}
}
if ($_GET['action'] == "mod") {
	$mid = intval($_GET['id']);
	setvar("MarketStatus", explode(",",lgg('yes_no')));
	if($mid){
		$sql = "select Market.id as MarketId,Market.name as MarketName,Market.content as MarketContent,Market.created as MarketCreated,Market.clicked as MarketClicked,Market.status as MarketStatus,Market.picture as MarketPicture,AreaProvince.name AS ProvinceName,AreaCity.name AS CityName,Industry.name as IndustryName from ".$table['market']." left join ".$table['area']." as AreaProvince on Market.province_id=AreaProvince.code_id left join ".$table['area']." as AreaCity on Market.city_id=AreaCity.code_id left join ".$table['industry']." on Market.industry_id=Industry.id where Market.id=".$mid;
		setvar("m",$g_db->GetRow($sql));
	}
	$tRes = $industry->getAllIndustry(" AND parentid='0'");
	if(!empty($tRes)){
		$pRes = null;
		foreach($tRes as $key=>$val){
			$pRes.="<option value=".$val['ID'].">".$val['Name']."</option>";
			$ttRes = $industry->getAllIndustry(" AND parentid=".$val['ID']);
			foreach($ttRes as $key2=>$val2){
				$pRes.="<option value=".$val2['ID'].">&nbsp;&nbsp;".$val2['Name']."</option>";
			}
		}
	}
	setvar("ParentIndustryOptions", $pRes);
	$tpl_file = "market_edit";
}else {
	$fields = "Market.id as MarketId,Market.name as MarketName,Market.status as MarketStatus";

	unset($joins);
	$amount = $market->findCount();
	pageft($amount,$display_eve_page);

	$joins = array(
	"AreaCountry"=>array("fullTableName"=>$area->getTable()." as AreaCountry","foreignKey"=>"country_id","fields"=>"AreaCountry.name as CountryName","PrimaryKey"=>"code_id"),
	"AreaProvince"=>array("fullTableName"=>$area->getTable()." as AreaProvince","foreignKey"=>"province_id","fields"=>"AreaProvince.name as ProvinceName","PrimaryKey"=>"code_id"),
	"AreaCity"=>array("fullTableName"=>$area->getTable()." as AreaCity","foreignKey"=>"city_id","fields"=>"AreaCity.name as CityName","PrimaryKey"=>"code_id"),
	"Industry"=>array("fullTableName"=>$industry->getTable(true),"foreignKey"=>"industry_id","fields"=>"Industry.name as IndustryName")
	);
	setvar("MarketList",$market->findAll($fields, $conditions, "Market.id desc", $firstcount, $displaypg));
	uaAssign(array("Amount"=>$amount,"PageHeader"=>$page_header,"ByPages"=>$pagenav));
}
template($tpl_file);
?>