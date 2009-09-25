<?php
if (!defined('DIRECTORY_SEPARATOR')) {
	/**
	* if your os is windows, use '\\'
	*/
	define('DIRECTORY_SEPARATOR','/');
}
define('PHPB2B_VERSION', '3.0 Dev');
define('DS', DIRECTORY_SEPARATOR);
define('BASE_DIR', substr(dirname(__FILE__), 0, -7));
if(!defined('SOURCE_PATH')) define('SOURCE_PATH',BASE_DIR.'libraries'.DS.'source'.DS);
if(!defined('LIB_PATH')) define('LIB_PATH',BASE_DIR.'libraries'.DS);
if(!defined('URL')) define('URL','%PHPB2B_SETUP_URL%');
define('STATIC_HTML_LEVEL',0);
define('PRETEND_HTML_LEVEL',0);
define('AUTH_KEY','%PHPB2B_AUTH_KEY%');
define('INSTALLED','%PHPB2B_SETUP_INSTALLED%');
$forums = array("switch"=>'%FORUM_SWITCH%', "type"=>"%FORUM_TYPE%", "url"=>"%FORUM_URL%");
$cookiepre = "EUA_";
$cookiedomain = "";
$cookiepath = "/";
$app_lang = "%APPLICATION_LANGUAGE%";
$charset = "utf-8";
$dbcharset = "utf8";
$theme_name = "default";
?>