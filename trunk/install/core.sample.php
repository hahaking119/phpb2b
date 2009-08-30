<?php
if (!defined('DIRECTORY_SEPARATOR')) {
	/**
	* if your os is windows, use '\\'
	*/
	define('DIRECTORY_SEPARATOR','/');
}
define('PHPB2B_VERSION', '2.5');
define('DS', DIRECTORY_SEPARATOR);
define('BASE_DIR', substr(dirname(__FILE__), 0, -11));
if(!defined('INC_PATH')) define('INC_PATH',BASE_DIR.APP_NAME.'source'.DS);
if(!defined('LIB_PATH')) define('LIB_PATH',BASE_DIR.APP_NAME.'libs'.DS);
if(!defined('URL')) define('URL','%UALINK_SETUP_URL%');
define('SMARTY_DIR', INC_PATH . 'smarty'.DS);
define('ADODB_DIR', INC_PATH . 'adodb'.DS);
define('STATIC_HTML_LEVEL',0);
define('PRETEND_HTML_LEVEL',0);
define('AUTH_KEY','%UALINK_AUTH_KEY%');
define('INSTALLED','%UALINK_SETUP_INSTALLED%');
$forums = array("switch"=>'%FORUM_SWITCH%', "type"=>"%FORUM_TYPE%", "url"=>"%FORUM_URL%");
$cookiepre = "EUA_";
$cookiedomain = "";
$cookiepath = "/";
$app_lang = "%APPLICATION_LANGUAGE%";
$charset = "utf-8";
$dbcharset = "utf8";
$theme_name = "default";
?>