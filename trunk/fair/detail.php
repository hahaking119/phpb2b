<?php
$inc_path = "../";
$li = 8;
require($inc_path."global.php");
uses("expo", "expotype", "area");
$fair = new Expoes();
$area = new Areas();
$fairtype = new Expotypes();
@require(SITE_ROOT."data/tmp/data/".$cookiepre."area.inc.php");
if (isset($_GET['title'])) {
	$fid = $fair->field("id", "ea='".urldecode(trim($_GET['title']))."'");
}
if (isset($_GET['id'])) {
	$fid = intval($_GET['id']);
}
if (empty($fid)) {
	alert(lgg("expo_not_exists"));
}
$fields = $fair->getFieldAliasNames();

$result = $g_db->GetRow("select ".$fields.",Expotype.name as ExpotypeName from ".$fair->getTable(true)." left join ".$fairtype->getTable(true)." on Expo.type_id=Expotype.id where Expo.id=".$fid);

if(!empty($result)){
	if(!empty($result['ExpoEw'])) {
		$fair_companies = unserialize($result['ExpoEw']);
		setvar("FairCompany", $fair_companies);
	}
	$result['CountryName'] = $UL_DBCACHE_AREAS[$result['ExpoCountryId']];
	$result['ProvinceName'] = $UL_DBCACHE_AREAS[$result['ExpoCountryId']];
	$result['CityName'] = $UL_DBCACHE_AREAS[$result['ExpoProvinceId']];
	$_titles[] = $result['ExpoEa'];
	setvar("ExpoRes", $result);
}else{
	alert(urlencode(sprintf(lgg("record_not_exists"), $fid)));
}
$_titles[] = lgg("expo_channel");
$fair->setPageTitle($_titles);
setvar("pageTitle", $fair->title);
template($theme_name."/fair_detail");
?>