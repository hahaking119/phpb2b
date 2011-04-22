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
session_start();
require("../libraries/common.inc.php");
require(PHPB2B_ROOT. './libraries/func.sql.php');
require("session_cp.inc.php");
$system_info = array();
uses("setting", "adminnote");
$setting = new Settings();
$adminnote = new Adminnotes();
$serverinfo = PHP_OS.' / PHP v'.PHP_VERSION;
$serverinfo .= @ini_get('safe_mode') ? ' Safe Mode' : NULL;
$dbversion = PbModel::getMysqlVersion();
$system_info['PhpVersion'] = $serverinfo;
$system_info["MysqlVersion"] = $dbversion;
$when_to_backup = $_PB_CACHE['setting']['backup_type'];
$system_info["LastBackupTime"] = $_PB_CACHE['setting']['last_backup'];
$system_info['InstallDate'] = date('Y-m-d', file_exists(DATA_PATH. 'install.lock')?filemtime(DATA_PATH. 'install.lock'):$pdb->GetOne("SELECT valued FROM {$tb_prefix}settings WHERE variable='install_dateline'"));
$system_info['last_login'] = date("Y-m-d H:i:s", $adminer_info['last_login']);
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
$system_info["DatabaseSize"] = number_format($dbssize)." Bytes OR ".size_info($dbssize);
$system_info["software"] = pb_getenv('SERVER_SOFTWARE');
$system_info["DatabaseSize"] = number_format($dbssize)." Bytes OR ".size_info($dbssize);
$system_info["operatingsystem"] = php_uname();
setvar("item", $system_info);
template("welcome");
?>