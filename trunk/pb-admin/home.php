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
 * @version $Id: home.php 427 2009-12-26 13:45:47Z steven $
 */
require("../libraries/common.inc.php");
if (session_id() == '' ) { 
	require_once(LIB_PATH. "session_php.class.php");
	$session = new PbSessions();
}
require(PHPB2B_ROOT. './libraries/func.sql.php');
require("session_cp.inc.php");
$system_info = array();
uses("setting", "adminnote");
$setting = new Settings();
$adminnote = new Adminnotes();
if (isset($_GET['do'])) {
	$do == trim($_GET['do']);
	if($do == "set_update_alert") {
		$vals['update_alert_type'] = intval($_GET['type']);
		$vals['update_alert_lasttime'] = $time_stamp;
		$setting->replace($vals, 1);
		die(L("action_successfully"));
	}
}
$serverinfo = PHP_OS.' / PHP v'.PHP_VERSION;
$serverinfo .= @ini_get('safe_mode') ? ' Safe Mode' : NULL;
$dbversion = PbModel::getMysqlVersion();
$system_info['PhpVersion'] = $serverinfo;
$system_info["MysqlVersion"] = $dbversion;
$when_to_backup = $_PB_CACHE['setting']['backup_type'];
$system_info["LastBackupTime"] = $_PB_CACHE['setting']['last_backup'];
$system_info['InstallDate'] = date('Y-m-d', file_exists(DATA_PATH. 'install.lock')?filemtime(DATA_PATH. 'install.lock'):$pdb->GetOne("SELECT valued FROM {$tb_prefix}settings WHERE variable='install_dateline'"));
$system_info['last_login'] = (!empty($adminer_info['last_login']))?date("Y-m-d H:i:s", $adminer_info['last_login']):L("your_first_login", "tpl");
$system_info['last_ip'] = $adminer_info['last_ip'];
if(!isset($_SESSION['last_adminer_time'])){
	$pdb->Execute("update {$tb_prefix}adminfields set last_login={$time_stamp},last_ip='".pb_get_client_ip('str')."' where member_id={$adminer_info['member_id']}");
	$_SESSION['last_adminer_time'] = $time_stamp;
}
if (isset($_POST['addAdminnote'])) {
	$info = $_POST['data']['adminnote'];
	$info['created'] = $time_stamp;
	$info['create_dateline'] = $date_line;
	$adminnote->save($info);
}
function checkGDSupport(){
	if(!function_exists("gd_info")){
		return false;
	}else {
		if(function_exists("ImageCreateFromGIF")) $return[] = L('gif_ok', 'tpl');
		if(function_exists("ImageCreateFromJPEG")) $return[] = L('jpg_ok', 'tpl');
		if(function_exists("ImageCreateFromPNG")) $return[] = L('png_ok', 'tpl');
		if(function_exists("ImageCreateFromWBMP")) $return[] = L('wbmp_ok', 'tpl');
		return $return;
	}
}
$gd_s = checkGDSupport();
$system_info["GDSupports"] = $gd_ss = (!$gd_s)?L('without_this_ext', 'tpl'):implode(",", $gd_s);
$rows = $pdb->Execute("SHOW TABLE STATUS");
$dbssize = 0;
foreach ($rows as $row) {
  $dbssize += $row['Data_length'] + $row['Index_length'];
}
$system_info["PBVersion"] = strtoupper(PHPB2B_VERSION." ({$charset})");
$system_info["DatabaseSize"] = number_format($dbssize)." Bytes ".L("or", "tpl").size_info($dbssize);
$system_info["software"] = pb_getenv('SERVER_SOFTWARE');
$system_info["operatingsystem"] = php_uname();
setvar("item", $system_info);
//check version
$support_url = "http://www.phpb2b.com/checkversion.php?version=".rawurlencode(PHPB2B_VERSION)."&lang=".$app_lang."&release=".PHPB2B_RELEASE."&charset={$charset}&dbcharset={$dbcharset}";
if (version_compare(PHP_VERSION, '5.0.0') >= 0) {
	$opts = array( 
		'http'=>array( 
		'method'=>"GET", 
		'timeout'=>60, 
	)
	); 
	$context = stream_context_create($opts);
	$file_contents = file_get_contents($support_url,  false, $context);	
}else{
	$file_contents = file_get_contents($support_url,  false);	
}
$has_newversion = false;
if (empty($file_contents) || !$file_contents) {
	;
}else{
	//get update alert set
	$file_contents = base64_decode($file_contents);
	$file_contents = @iconv("utf-8", $charset, $file_contents);
	$file_contents = explode("|", $file_contents);
	list($force, $content) = $file_contents;
	if($force){
		$has_newversion = true;
	}else{
		$if_alert = intval($setting->field("valued", "variable='update_alert_type'"));
		switch ($if_alert) {
			case 0:
				$has_newversion = true;
				break;
			case 1:
				break;
			default:
				$last_alert_time = $setting->field("valued", "variable='update_alert_lasttime'");
				if($time_stamp>=($last_alert_time+$if_alert*86400)){
					$has_newversion = true;
				}
				break;
		}
	}
}
if($has_newversion){
	setvar("VersionInfo", $content);
	setvar("hasNewVersion", $has_newversion);
}
setvar("SupportUrl", $support_url);
template("welcome");
?>