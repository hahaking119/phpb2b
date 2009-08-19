<?php
$inc_path = "../";
$li = 6;
require($inc_path."global.php");
uses("market","industry", "setting");
$market = new Markets();
$setting = new Settings();
$industry = new Industries();
if (!isset($_COOKIE[session_name()])) {
	setcookie(session_name(), md5(getRadomStr()), $time_stamp+3*86400);
}
$salt = substr($_COOKIE[session_name()], 0, 10);
if (isset($_POST['addmarket']) && !empty($_POST['market'])) {
	//check today
	$tVisitLogNum = $g_db->GetOne("select count(id) from ".$tb_prefix."visitlogs where salt='$salt' and  date_line='".date("Ymd")."' and type_name='markets'");
	if ($tVisitLogNum>=3) {
		alert(sprintf(lgg('visit_limit'), 3));
	}
	$vals = array();
	$vals['name'] = $_POST['market']['name'];
	$vals['content'] = $_POST['market']['content'];
	$vals['country_id'] = $_POST['countryid'];
	$vals['province_id'] = $_POST['provinceid'];
	$vals['city_id'] = $_POST['cityid'];
	if($_POST['city_id']){
		$vals['ma'] = $_POST['city_id'];
	}elseif ($_POST['province_id']) {
		$vals['ma'] = $_POST['province_id'];
	}
	if(isset($_POST['bindustry'])){
		$industryid = $_POST['bindustry'];
	}else if(isset($_POST['aindustry'])){
		$industryid = $_POST['aindustry'];
	}
	$vals['industry_id'] = $industryid;
	$vals['created'] = time();
	$vals['mb'] = uaGetClientIP();
	array_walk($vals, "uatrim");

	$sh_check = intval($setting->field("ab", "aa='add_market_check'"));
	if ($sh_check) {
		$vals['status'] = 0;
	}else{
		$vals['status'] = 1;
	}
	$result = $market->save($vals);
	if ($result) {
		$g_db->Execute("insert into ".$tb_prefix."visitlogs (salt,date_line,type_name) value ('".$salt."','".date("Ymd")."','markets');");
		alert(lgg('wait_add'));
	}else {
		goto("./add.php");
	}
}
include("./industry.php");
template($theme_name."/market_add");
?>