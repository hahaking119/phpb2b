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
 * @version $Id: passport.php 427 2009-12-26 13:45:47Z steven $
 */
require("../libraries/common.inc.php");
require("session_cp.inc.php");
require(API_PATH. "passport.class.php");
require(LIB_PATH. "file.class.php");
require(LIB_PATH. "cache.class.php");
uses("setting");
$cache = new Caches();
$setting = new Settings();
$file = new Files();
$passport = new Passports();
$tpl_file = "passport";
require(LIB_PATH. "typemodel.inc.php");
setvar("AskAction", get_cache_type("common_option"));
if (isset($_POST['do'])) {
	$do = trim($_POST['do']);
	if ($do == "setting") {
		$updated = $setting->replace($_POST['data']['setting']);
		if($updated){
			$cache->writeCache("setting", "setting");
			flash("success");
		}
	}
}
if (isset($_POST['save'])) {
	$datas = $_POST['data']['passport'];
	if (isset($_POST['id'])) {
		$id = intval($_POST['id']);
	}
	if (!empty($_POST['data']['config'])) {
		$datas['config'] = serialize($_POST['data']['config']);
	}
	if (!empty($id)) {
		$result = $pdb->Execute("UPDATE {$tb_prefix}passports SET title='".$datas['title']."',url='".$datas['url']."',description='".$datas['description']."',available='".$datas['available']."',config='".$datas['config']."',modified={$time_stamp} WHERE id=".$id);
	}else{
		$result = $pdb->Execute("INSERT INTO {$tb_prefix}passports (name,title,description,url,available,config,created,modified) VALUE ('".$datas['name']."','".$datas['title']."','".$datas['description']."','".$datas['url']."','".$datas['available']."','".$datas['config']."',{$time_stamp},{$time_stamp});");
	}
	if ($datas['name'] == "ucenter") {
		if (!$file->file_writeable($passport->passport_path.$datas['name'].DS."config.inc.php")) {
			flash("file_not_writeable", null, 0);
		}else{
			$passport->writeConfig($datas['name'].DS."config.inc.php", $_POST['data']['config']);
		}
	}
	if (!$result) {
		flash("action_failed", null, 0);
	}else{
		pheader("Location:passport.php");
	}
}
if (isset($_GET['do'])) {
	$do = trim($_GET['do']);
	if (!empty($_GET['id'])) {
		$id = intval($_GET['id']);
	}
	
	if ($do == "set") {
		$item = $pdb->GetRow("SELECT valued AS passport_support FROM {$tb_prefix}settings WHERE variable='passport_support'");
		setvar("item", $item);
		$tpl_file = "passport.set";
		template($tpl_file);
		exit;
	}
	if (!empty($_GET['entry'])) {
		$entry = trim($_GET['entry']);
		$tpl_path = API_PATH. "passports".DS.$entry.DS."template".DS;
		if (is_dir($tpl_path)) {
			$tpl_file = $tpl_path. "setting";
			if ($do == "install") {
				$item['name'] = $entry;
			}elseif($do == "edit" && !empty($id)){
				$result = $pdb->GetRow("SELECT * FROM {$tb_prefix}passports WHERE id=".$id);
				if (!empty($result['config'])) {
					$configs = unserialize($result['config']);
					$item = array_merge($result, $configs);
					unset($result['config']);
				}
			}
			setvar("item", $item);
			template($tpl_file);
			exit;
		}
	}
	if ($do == "uninstall" && !empty($id)) {
		$passport->uninstall($id);
	}
}
if (!$_PB_CACHE['setting']['passport_support']) {
	flash("open_passport_support_first", "passport.php?do=set");
}
$result = $passport->getPassports();
setvar("Items", $result);
template($tpl_file);
?>