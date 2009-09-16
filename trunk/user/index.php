<?php
$inc_path = "../";
require($inc_path."global.php");
require(SOURCE_PATH .'xajax/xajaxAIO.inc.php');
uses("setting", "htmlcache");
$htmlcache = new Htmlcaches();
$setting = new Settings();
$xajax = new xajax();
$xajax->configure('javascript URI', URL."libraries/source/xajax/");
$xajax->processRequest();
setvar('xajax_javascript', $xajax->getJavascript());
setvar("SiteDescription", $setting->field("valued", "variable='site_description'"));
template($theme_name."/user_reg");
?>