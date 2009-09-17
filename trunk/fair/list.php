<?php
$inc_path = "../";
$li = 7;
require($inc_path."global.php");
require(SITE_ROOT.'./libraries/page.php');
uses("expo", "expotype");
$expo = new Expoes();
$expotype = new Expotypes();
if (isset($_GET['type'])) {
	if ($_GET['type']=="commend") {
		$_titles[] = lgg("recommend").lgg("expo_channel");
		$_positions[] = lgg("recommend").lgg("expo_channel");
	}
}
$_titles[] = lgg("expo_channel");
if(isset($_GET['type_id'])){
	$type_id = intval($_GET['type_id']);
	$conditions = "type_id=".$type_id;
	setvar("ExpotypeName", $type_name = $expotype->field("name", "id=".$type_id));
	$_titles[] = $type_name;
	$_positions[] = $type_name;
}
if (isset($_GET['province_code'])) {
	$conditions.=" and country_id=".intval($_GET['province_code']);
}
if (isset($_GET['city_code'])) {
	$conditions.=" and province_id=".intval($_GET['city_code']);
}
$expo->setPageTitle($_titles, $_positions);
$latest_fairs = $expo->findAll("id as FairId,ea as Title,eb as FairCreated", null, "id desc", 0, 10);
$type_fairs = $expo->findAll("id as FairId,ea as Title,eb as FairCreated,DATE_FORMAT('1997-10-04 22:23:00', '%Y.%c.%e') as begin_date", $conditions, "id desc", $firstcount, $displaypg);
uaAssign(array("pageTitle"=>$expo->title, "pagePosition"=>$expo->position));
setvar("ListFairs", $type_fairs);
setvar("LatesFairs", $latest_fairs);
template($theme_name."/fair_list");
?>