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
 * @version $Id: payment.php 427 2009-12-26 13:45:47Z steven $
 */
require("../libraries/common.inc.php");
require("session_cp.inc.php");
require(API_PATH. "payment.class.php");
require(LIB_PATH. "file.class.php");
require(LIB_PATH. "cache.class.php");
uses("setting");
$cache = new Caches();
$file = new Files();
$payment = new Payments();
$setting = new Settings();
$tpl_file = "payment";
require(LIB_PATH. "typemodel.inc.php");
setvar("AskAction", get_cache_type("common_option"));
$result = $payment->getpayments();
setvar("Items", $result);
$item = $setting->getValues(1);
if (isset($_POST['save_passport_rule'])) {
	$cache->writeCache("setting1", "setting1");
	$setting->replace($_POST['data']['setting1'], 1);
	flash("success");
}
if (isset($_POST['save'])) {
	$datas = $_POST['data']['payment'];
	if (isset($_POST['id'])) {
		$id = intval($_POST['id']);
	}
	if (!empty($_POST['data']['config'])) {
		$datas['config'] = serialize($_POST['data']['config']);
	}
	if (!empty($id)) {
		$result = $pdb->Execute("UPDATE {$tb_prefix}payments SET title='".$datas['title']."',description='".$datas['description']."',if_online_support='".$datas['if_online_support']."',available='".$datas['available']."',config='".$datas['config']."',modified={$time_stamp} WHERE id=".$id);
	}else{
		$result = $pdb->Execute("INSERT INTO {$tb_prefix}payments (name,title,description,available,config,created,modified) VALUE ('".$datas['name']."','".$datas['title']."','".$datas['description']."','".$datas['available']."','".$datas['config']."',{$time_stamp},{$time_stamp});");
	}
	if (!$result) {
		flash("action_failed", null, 0);
	}else{
		pheader("Location:payment.php");
	}
}
if (isset($_GET['do'])) {
	$do = trim($_GET['do']);
	if (!empty($_GET['id'])) {
		$id = intval($_GET['id']);
	}
	if ($do == "rule") {
		$tpl_file = "payment.rule";
		setvar("item", $item);
		template($tpl_file, 1);
	}
	if (!empty($_GET['entry'])) {
		$entry = trim($_GET['entry']);
		$tpl_file = $payment->payment_path.$entry.DS."template".DS."setting".$smarty->tpl_ext;
		if (!file_exists($tpl_file)) {
			flash('tpl_not_exists', null, 0);
		}else{
			if ($do == "install") {
				require($payment->payment_path.$entry.DS."info.inc.php");
				if($cfg['params']) {
					$item = array_merge($cfg, $cfg['params']);
				}else{
					$item = $cfg;
				}
			}elseif($do == "edit" && !empty($id)){
				$result = $pdb->GetRow("SELECT * FROM {$tb_prefix}payments WHERE id=".$id);
				if (!empty($result['config'])) {
					$configs = unserialize($result['config']);
					$item = array_merge($result, $configs);
					unset($result['config']);
				}else{
					$item = $result;
				}
			}
			setvar("item", $item);
			$smarty->display($tpl_file);
			exit;
		}
	}
	if ($do == "uninstall" && !empty($id)) {
		$payment->uninstall($id);
	}
}
template($tpl_file);
?>