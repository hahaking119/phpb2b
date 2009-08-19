<?php
$inc_path = "../";
require($inc_path."global.php");
require(INC_PATH .'xajax/xajaxAIO.inc.php');
uses("setting", "htmlcache");
$htmlcache = new Htmlcaches();
$setting = new Settings();
$xajax = new xajax();
$xajax->configure('javascript URI', URL."app/source/xajax/");
$xajax->register(XAJAX_FUNCTION,  new xajaxUserFunction('rebuildHTML', '../ajax.php'));
$xajax->processRequest();
setvar('xajax_javascript', $xajax->getJavascript());

if (isset($_POST['apply']) && !empty($_POST['site'])) {
	$result = false;
	$data['Service'] = array();
	$data['Service']['title'] = lgg('apply_friendlink').":".strip_tags($_POST['site']['name']);
	$data['Service']['content'] = serialize($_POST['site']);
	$data['Service']['created'] = $time_stamp;
	$data['Service']['user_ip'] = uaGetClientIP();
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
		goto("../message.php", 1, lgg('wait_apply'));
	}
}
setvar("SiteDescription", $setting->field("ab", "aa='site_description'"));
if (isset($_GET['action']) && $_GET['action']=="html") {
		$smarty->MakeHtmlFile('../htmls/user/apply_friendlink.html',$smarty->fetch($theme_name."/user_apply_friendlink.html"), true, "user/apply_friendlink.php");
}
template($theme_name."/user_apply_friendlink");
?>