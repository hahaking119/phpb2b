<?php
$inc_path = "../";
require($inc_path."global.php");
require(SOURCE_PATH .'xajax/xajaxAIO.inc.php');
uses("setting", "htmlcache");
$htmlcache = new Htmlcaches();
$setting = new Settings();
$xajax = new xajax();
$xajax->configure('javascript URI', URL."app/source/xajax/");
$xajax->processRequest();
setvar('xajax_javascript', $xajax->getJavascript());

if (isset($_POST['apply']) && !empty($_POST['site'])) {
	$result = false;
	$data['Service'] = array();
	$data['Service']['title'] = lgg('apply_friendlink').":".strip_tags($_POST['site']['name']);
	$data['Service']['content'] = serialize($_POST['site']);
	$data['Service']['created'] = $time_stamp;
	$data['Service']['user_ip'] = pb_get_client_ip('str');
	$data['Service']['email'] = $_POST['site']['email'];
	$data['Service']['type_id'] = 9;
	uses("service");
	$service = new Services();
	$result = $service->save($data['Service']);
	$data['Friendlink']['title'] = $data['Service']['title'];
	$data['Friendlink']['status'] = 0;
	$data['Friendlink']['url'] = $_POST['site']['url'];
	$data['Friendlink']['logo'] = $_POST['site']['logo'];
	$data['Friendlink']['created'] =$time_stamp;
	$result = $friendlink->save($data['Friendlink']);
	if ($result) {
		PB_goto("../redirect.php", 1, lgg('wait_apply'));
	}
}
setvar("SiteDescription", $setting->field("valued", "variable='site_description'"));
template($theme_name."/user_apply_friendlink");
?>