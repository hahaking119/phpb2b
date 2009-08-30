<?php
/**
 * Note : The Software shall be used for Good, not Evil.
 * PHPB2B - As an open source b2b program.
 *
 * Permission is hereby granted to use this version of the library under the
 * following license:
 *
 * --
 * Copyright (c) 2006-2009 Ualink (http://www.phpb2b.com/)
 *
 * All rights granted under this License are granted for the term of copyright on
 * the Program, and are irrevocable provided the stated conditions are met. This
 * License explicitly affirms your unlimited permission to run the unmodified Program.
 * The output from running a covered work is covered by this License only if the
 * output, given its content, constitutes a covered work.
 * This License acknowledges your rights of fair use or other equivalent, as provided
 * by copyright law.
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * --
 *
 * @package phpb2b
 * @copyright 2009 Ualink <phpb2b@hotmail.com> (http://www.phpb2b.com/)
 * @license http://www.opensource.org/licenses/gpl-license.php GPL License
 * @created Mon Jun 22 16:05:24 CST 2009
 * @link http://sourceforge.net/projects/php-b2b/
 * @version $Id$
 */
define('IN_UALINK', TRUE);
define('DEBUG', '0');
define('SITE_ROOT', dirname(__FILE__).DIRECTORY_SEPARATOR);

$gzipcompress = 0;//if use GZIP
$subdomain_support = 0;//0, Close;1, Open.
$config_subdomain = ".yourdomain.com";
//$is_apache = strstr($_SERVER['SERVER_SOFTWARE'], 'Apache') ? true : false;
define('APP_NAME', 'app/');
require(SITE_ROOT. './app/configs/core.php');
define('DATA_PATH', SITE_ROOT."./data/tmp/data/");
if (!INSTALLED) {
	if(file_exists("./install/install.php")){
		header("Location: ./install/install.php?step=-1");
		exit;
	}else{
		die("<a href='./install/install.php'>".lgg('pls_reinstall_program')."</a>!");
	}
}
require(SITE_ROOT. './app/configs/db.php');
if(!DEBUG){
	error_reporting(0);
}else{
	error_reporting(E_ALL);
	$g_db->debug = true;
}
require(SITE_ROOT. './app/include/class.my.smarty.php');
$smarty = new MySmarty($inc_path);
require(LIB_PATH. 'ualink_object.php');
require(LIB_PATH. 'ualink_model.php');
require(LIB_PATH. 'ualink_controller.php');
require(SITE_ROOT. './app/include/func.global.php');
require(DATA_PATH.$cookiepre."setting.inc.php");
if(isset($_SETTINGS['headercharset'])) {
    @header('Content-Type: text/html; charset='.$charset);
}
$time_stamp = time();
$media_paths = (STATIC_HTML_LEVEL<2)?$smarty->getRelativePath():$smarty->getAbsolutePath();
$media_paths = (PRETEND_HTML_LEVEL==0)?$smarty->getRelativePath():$smarty->getAbsolutePath();
uaAssign($media_paths);
uses("userpage");
$userpage = new Userpages();
$li = (!empty($li))?intval($li):0; $userpage->setLi($li);
$userpage->setUrlContainer(intval(STATIC_HTML_LEVEL));
$urls = $userpage->getUrlContainer();
$current_li = $userpage->getLi();
unset($conditions);
$ua_user = getMemberInfo();

if (isset($_GET['action']) && ($_GET['action'])=="html") {
	unset($ua_user);
}
uaAssign(array("subdomain"=>$config_subdomain, "SiteUrl"=>URL, "ThemeName"=>$theme_name, "Charset"=>$charset, "UalinkUser"=>$ua_user, $current_li=>"current", "ForumSet"=>$forums, "UrlContainer"=>$urls, "UaVersion"=>PHPB2B_VERSION));
uaAssign($_SETTINGS);
$magic_quote = get_magic_quotes_gpc();
//secure global
if(empty($magic_quote)) {
    $_GET = ulAddSlashes($_GET);
    $_POST = ulAddSlashes($_POST);
}
//secure cookie
$pre_length = strlen($cookiepre);
foreach($_COOKIE as $key => $val) {
	if(substr($key, 0, $pre_length) == $cookiepre) {
		$_UCOOKIE[(substr($key, $pre_length))] = empty($magic_quote) ? ulAddSlashes($val) : $val;
	}
}
//referer
$pre_refer = empty($_SERVER['HTTP_REFERER'])?'':$_SERVER['HTTP_REFERER'];
if($gzipcompress && function_exists('ob_gzhandler')) {
	ob_start('ob_gzhandler');
} else {
	$gzipcompress = 0;
	ob_start();
}
//li
if(isset($li)){
	if($li==3){
		$headerFrmAction = URL."company.php";
	}elseif($li==4){
		$headerFrmAction = URL."product/list.php";
	}elseif($li==5){
		$headerFrmAction = URL."news/list.php";
	}elseif($li==6){
		$headerFrmAction = URL."market/list.php";
	}elseif($li==7){
		$headerFrmAction = URL."fair/list.php";
	}elseif($li==8){
		$headerFrmAction = URL."hr.php";
	}elseif($li==99){
		$headerFrmAction = URL."tag.php";
	}else{
		$headerFrmAction = URL."offer/list.php";
	}
	setvar("HeaderFormAction", $headerFrmAction);
}
?>