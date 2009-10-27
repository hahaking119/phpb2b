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
setvar("SiteDescription", $setting->field("ab", "aa='site_description'"));
if (isset($_GET['action']) && $_GET['action']=="html") {
	$smarty->MakeHtmlFile('../htmls/user/index.html',$smarty->fetch($theme_name."/user_reg.html"), true, "user/index.php");
}
template($theme_name."/user_reg");
?>