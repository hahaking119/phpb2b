<?php
/**
 * NOTE   :  PHP versions 4 and 5
 *
 * PHPB2B :  An Opensource Business To Business E-Commerce Script (http://www.phpb2b.com/)
 * Copyright 2007-2009, Ualink E-Commerce Co,. Ltd.
 *
 * Licensed under The GPL License (http://www.opensource.org/licenses/gpl-license.php)
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * @copyright Copyright 2007-2009, Ualink E-Commerce Co,. Ltd. (http://phpb2b.com)
 * @since PHPB2B v 1.0.0
 * @link http://phpb2b.com
 * @package phpb2b
 * @version $Id: common.inc.php 462 2009-12-27 03:20:41Z steven $
 */
define('IN_PHPB2B', TRUE);
define('PHPB2B_ROOT', substr(dirname(__FILE__), 0, -9));
define('MAGIC_QUOTES_GPC', function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc());
if (!defined('DIRECTORY_SEPARATOR')) {
	define('DIRECTORY_SEPARATOR','/');
}
define('DS', DIRECTORY_SEPARATOR);
require(PHPB2B_ROOT. 'configs'.DS.'config.inc.php');

/**
 * PHPB2B DEBUG LEVEL:
 * MYABE 0-5
 */
if(!isset($debug)) $debug = 0;
require(PHPB2B_ROOT.'languages'.DS.$app_lang.DS.'template.inc.php');
require(PHPB2B_ROOT.'languages'.DS.$app_lang.DS.'message.inc.php');
require(PHPB2B_ROOT. 'libraries'.DS.'global.func.php');
require(PHPB2B_ROOT. 'configs'.DS.'paths.php');
include(CACHE_PATH. 'cache_setting.php');
$httpHost = pb_getenv('HTTP_HOST');
if(!defined('URL')) {
	if (!empty($absolute_uri)) {
		define('URL', $absolute_uri);	
	}else{
		$s = $uri = null;
		if (pb_getenv('HTTPS')) {
			$s ='s';
		}
		$uri = $_SERVER['REQUEST_URI']?$_SERVER['REQUEST_URI']:($_SERVER['PHP_SELF']?$_SERVER['PHP_SELF']:$_SERVER['SCRIPT_NAME']);
		define('URL', htmlspecialchars('http://'.$s.$_SERVER['HTTP_HOST'].substr($uri, 0, strrpos($uri, '/')+1)));	
	}
}
$time_start = getmicrotime();
$time_stamp = time();
$date_line = date("Y-m-d H:i:s", $time_stamp);
$includes = array(
	SOURCE_PATH. 'adodb'.DS.'adodb.inc.php',
	PHPB2B_ROOT. 'libraries'.DS.'smarty.pb.class.php',
	LIB_PATH. 'pb_object.php',
	LIB_PATH. 'pb_model.php',
	LIB_PATH. 'pb_controller.php',
	LIB_PATH. 'pb_view.php',
);
foreach ($includes as $inc) {
	if (!file_exists($inc)) {
		trigger_error(sprintf(L("file_not_exists"), $inc));
	}else{
		require($inc);
	}
}
$pdb = &NewADOConnection($database);
$smarty = new MySmarty();
$connected = $pdb->PConnect($dbhost,$dbuser,$dbpasswd,$dbname);
if(!$connected or empty($connected)) {
	$msg = L("db_conn_error", 'msg', $pdb->ErrorMsg());
	$msg.= "<br />".L("db_conn_error_no", 'msg', $pdb->ErrorNo());
	header_sent($msg);
	exit;
}
if($dbcharset) {
	$pdb->Execute("SET NAMES '{$dbcharset}'");
}
$phpb2b_auth_key = md5($_PB_CACHE['setting']['auth_key'].pb_getenv('HTTP_USER_AGENT'));
$php_self = pb_getenv('PHP_SELF');
$base_script = basename($php_self);
list($basefilename) = explode('.', $base_script);
if($headercharset) {
    @header('Content-Type: text/html; charset='.$charset);
}
//timezone
$time_offset = isset($_PB_CACHE['setting']['time_offset'])?$_PB_CACHE['setting']['time_offset']:0;
$date_format = isset($_PB_CACHE['setting']['date_format'])?$_PB_CACHE['setting']['date_format']:"Y-m-d";
$time_now = array('time' => gmdate("{$date_format} H:i", $time_stamp + 3600 * $time_offset),
	'offset' => ($time_offset >= 0 ? ($time_offset == 0 ? '' : '+'.$time_offset) : $time_offset));

if(PHP_VERSION > '5.1') {
	@date_default_timezone_set('Etc/GMT'.($time_offset > 0 ? '-' : '+').(abs($time_offset)));
}else{
	@putenv("TZ=GMT".$time_now['offset']);
}
$viewhelper = new PbView();
$conditions = null;
$pb_userinfo = pb_get_member_info();
if ($pb_userinfo) {
	$pb_user = $pb_userinfo;
	$pb_user = pb_addslashes($pb_user);
	uaAssign($pb_userinfo);
}
uaAssign(array('SiteUrl'=>URL, 'Charset'=>$charset));
uaAssign($_PB_CACHE['setting']);
$pre_length = strlen($cookiepre);
foreach($_COOKIE as $key => $val) {
	if(substr($key, 0, $pre_length) == $cookiepre) {
		$_UCOOKIE[(substr($key, $pre_length))] = MAGIC_QUOTES_GPC ? $val : pb_addslashes($val);
	}
}
$pre_refer = empty($_SERVER['HTTP_REFERER'])?'':$_SERVER['HTTP_REFERER'];
if($gzipcompress && function_exists('ob_gzhandler')) {
	ob_start('ob_gzhandler');
} else {
	$gzipcompress = 0;
	ob_start();
}
?>