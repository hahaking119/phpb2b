<?php
if (!defined('DIRECTORY_SEPARATOR')) {
	/**
	* if your os is windows, use '\\'
	*/
	define('DIRECTORY_SEPARATOR','/');
}
define('PHPB2B_VERSION', '3.0 Dev');
define('DS', DIRECTORY_SEPARATOR);
define('BASE_DIR', substr(dirname(__FILE__), 0, -11));
if(!defined('INC_PATH')) define('INC_PATH',BASE_DIR.APP_NAME.'source'.DS);
if(!defined('LIB_PATH')) define('LIB_PATH',BASE_DIR.APP_NAME.'libs'.DS);
if(!defined('URL')) define('URL','http://www.yourdomain.com/');
define('SMARTY_DIR', INC_PATH . 'smarty'.DS);
define('ADODB_DIR', INC_PATH . 'adodb'.DS);
define('STATIC_HTML_LEVEL',0);
define('PRETEND_HTML_LEVEL',0);
define('AUTH_KEY','put_your_auth_key_here');
define('INSTALLED','0');
$forums = array("switch"=>'0', "type"=>null, "url"=>null);
$cookiepre = "EUA_";
$cookiedomain = "";
$cookiepath = "/";
$app_lang = "zh-cn";
$charset = "utf-8";
$dbcharset = "utf8";
$theme_name = "default";
?>