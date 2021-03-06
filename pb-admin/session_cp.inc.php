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
 * @version $Id: session_cp.inc.php 585 2009-12-28 13:41:44Z steven $
 */
define('IN_PBADMIN', TRUE);
if(empty($_COOKIE[$cookiepre.'admin']) || !($_COOKIE[$cookiepre.'admin'])){
	echo "<script language='javascript'>top.location.href='login.php';</script>";
	exit;
}else{
	uses("adminfield");
	$adminer = new Adminfields();	
    $tAdminInfo = authcode($_COOKIE[$cookiepre.'admin'], "DECODE");
    $tAdminInfo = explode("\n", $tAdminInfo);
    $current_adminer_id = $tAdminInfo[0];
    $current_adminer = $tAdminInfo[1];
    $current_pass = $tAdminInfo[2];
    $adminer->loadsession($current_adminer_id, pb_get_client_ip("str"), $cfg_checkip);
    $adminer_info = $adminer->info;
    uaAssign(array("current_adminer"=>$current_adminer, "current_adminer_id"=>$current_adminer_id));
}
require(PHPB2B_ROOT.'languages'.DS.$app_lang.DS.'template.admin.inc.php');
require(PHPB2B_ROOT.'languages'.DS.$app_lang.DS.'template.adminmenu.inc.php');
require(PHPB2B_ROOT. 'phpb2b_version.php');
$smarty->template_dir = "template/";
$smarty->setCompileDir("pb-admin".DS);
$smarty->flash_layout = "flash";
$smarty->assign("addParams", $viewhelper->addParams);
$smarty->assign("today_timestamp", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
if (!empty($arrTemplate)) {
    $smarty->assign($arrTemplate);
}
function size_info($fileSize) {
	$size = sprintf("%u", $fileSize);
	if($size == 0) {
		return("0 Bytes");
	}
	$sizename = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
	return round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $sizename[$i];
}
?>