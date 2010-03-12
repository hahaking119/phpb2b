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
 * @version $Id: setting.php 427 2009-12-26 13:45:47Z steven $
 */
require("../configs/config.inc.php");
require("../libraries/common.inc.php");
require("session_cp.inc.php");
require(LIB_PATH. "cache.class.php");
require(LIB_PATH. "string.class.php");
require(LIB_PATH. "typemodel.inc.php");
require(PHPB2B_ROOT.'languages'.DS.$app_lang.DS.'emails.inc.php');
uses("setting");
$cache = new Caches();
$string = new Strings();
$setting = new Settings();
setvar("AskAction", get_cache_type("common_option"));
$tpl_file = "setting.basic";
$item = $setting->getValues();
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'){
	//echo "win";
}
if (isset($_POST['do'])) {
	$do = trim($_POST['do']);
	switch ($do) {
		case "testemail":
			require(LIB_PATH. 'sendmail.inc.php');
			if (!empty($_POST['data']['testemail'])) {
				$sended = pb_sendmail($_POST['data']['testemail'], L("dear_user", "tpl"), L("a_test_email", "tpl"), L("a_test_email_delete", "tpl"));
				if (!$sended) {
					flash("email_sended_false");
				}else{
					flash("email_sended_success");
				}
			}
			break;
		default:
			break;
	}
}
if (isset($_GET['do'])) {
	$do = trim($_GET['do']);
	switch ($do) {
		case "basic":
			$tpl_file = "setting.basic";
			break;
		case "basic_desc":
			$tpl_file = "setting.basic.desc";
			break;
		case "basic_contact":
			$tpl_file = "setting.basic.contact";
			break;
		case "datetime":
			if (isset($item['DATE_FORMAT'])) {
				$tmp_str = explode("-", $item['DATE_FORMAT']);
				$tmp_arr = array();
				foreach ($tmp_str as $key=>$val) {
					$tmp_arr[] = "%".$val;
				}
				$item['DATE_FORMAT'] = implode("-", $tmp_arr);
			}
			$tpl_file = "setting.datetime";
			break;
		case "auth":
			$tpl_file = "setting.auth";
			break;
		case "secure":
			$tpl_file = "setting.auth.secure";
			break;
		case "cache":
			$tpl_file = "setting.cache";
			break;
		case "permission":
			$tpl_file = "setting.permission";
			break;
		case "email":
			$tpl_file = "setting.email";
			break;
		case "functions":
			if($subdomain_support){
				$item['subdomain_support'] = 1;
				$item['subdomain'] = $subdomain_support;
			}
			$item['topleveldomain_support'] = ($topleveldomain_support)?1:0;
			$item['rewrite_able'] = ($rewrite_able)?1:0;
			$item['rewrite_compatible'] = ($rewrite_compatible)?1:0;
			$tpl_file = "setting.functions";
			break;
		case "register":
			$words = $pdb->GetArray("SELECT * FROM {$tb_prefix}words");
			if (!empty($words)) {
				foreach ($words as $word_val) {
					if(!empty($word_val['title'])) $tmp_str[] = $word_val['title'];
				}
				$item['forbid_word'] = implode("\r\n", $tmp_str);
			}
			$ips = $pdb->GetArray("SELECT CONCAT(ip1,'.',ip2,'.',ip3,'.',ip4) AS ip FROM {$tb_prefix}ipbanned");
			if (!empty($ips)) {
				foreach ($ips as $ip_val) {
					if(!empty($ip_val['ip'])) $tmp_ip[] = $ip_val['ip'];
				}
				$item['forbid_ip'] = implode("\r\n", $tmp_ip);
			}
			$item['agreement'] = file_get_contents(CACHE_PATH. "cache_agreement.php");
			$tpl_file = "setting.register";
			break;
		case "registerfile":
			$tpl_file = "setting.register.file";
			break;
		default:
			break;
	}
}
function edit_config($configs) {
	global $dbcharset;
	if (!is_array($configs)) {
		return;
	}
	extract($configs);
	$configfile = PHPB2B_ROOT. 'configs'.DS.'config.inc.php';
	$configfiles = file_get_contents($configfile);
	$configfiles = trim($configfiles);
	$configfiles = substr($configfiles, -2) == '?>' ? substr($configfiles, 0, -2) : $configfiles;
	$configfiles = preg_replace("/[$]absolute_uri\s*\=\s*[\"'].*?[\"'];/is", "\$absolute_uri = '".$absolute_uri."';", $configfiles);
	if(file_put_contents($configfile, $configfiles)){
		return true;
	}else{
		return false;
	}
}
if (isset($_POST['savebasic'])) {
	$sp_search = array('\\\"', "\\\'", "'");
	$sp_replace = array('&amp;', '&quot;', '&#39;');
	if (!empty($_POST['data']['setting1'])) {
		$_POST['data']['setting1']['site_description'] = str_replace($sp_search, $sp_replace, $_POST['data']['setting1']['site_description']);
		$setting->replace($_POST['data']['setting1'], 1);
	}
	$updated = $setting->replace($_POST['data']['setting']);
	if($updated){
		$cache->writeCache("setting", "setting");
		if (!empty($_POST['data']['setting']['site_url']) && (!pb_strcomp($_POST['data']['setting']['site_url'], $absolute_uri))) {
			edit_config(array("absolute_uri"=>$_POST['data']['setting']['site_url']));
		}
		flash("success", "setting.php?do=basic");
	}else{
		flash();
	}
}
if (isset($_POST['saveauth'])) {
	$updated = $setting->replace($_POST['data']['setting']);
	if($updated){
		$cache->writeCache("setting", "setting");
		pheader("location:setting.php?do=auth");
	}
}
if (isset($_POST['save_datetime'])) {
	$vals = array();
	if (isset($_POST['data']['time_offset'])) {
		$vals['time_offset'] = intval($_POST['data']['time_offset']);
	}
	if (isset($_POST['data']['date_format'])) {
		$vals['date_format'] = str_replace("%", "", $_POST['data']['date_format']);
	}
	$updated = $setting->replace($vals);
	if($updated){
		$cache->writeCache("setting", "setting");
		pheader("location:setting.php?do=datetime");
	}
}
if (isset($_POST['saveregister'])) {
	$updated = false;
	if (isset($_POST['data']['setting']['register_type']) && $_POST['data']['setting']['register_type']!="close_register") {
		if (!empty($_POST['data']['agreement'])) {
			$cache->updateAgreement($_POST['data']['agreement']);
		}
		if (!empty($_POST['data']['setting']['reg_filename']) && !pb_strcomp($_POST['data']['setting']['reg_filename'],$_POST['data']['reg_filename'])) {
		    $renameResult = rename(PHPB2B_ROOT. 'register.php', PHPB2B_ROOT.$_POST['data']['setting']['reg_filename']);
		}
		if (!empty($_POST['data']['setting']['post_filename']) && !pb_strcomp($_POST['data']['setting']['post_filename'],$_POST['data']['post_filename'])) {
		    $renameResult = rename(PHPB2B_ROOT. 'post.php', PHPB2B_ROOT. $_POST['data']['setting']['post_filename']);
		}		
	}
	if (!empty($_POST['data']['forbid_ip'])) {
		$datas = $string->txt2array($_POST['data']['forbid_ip']);
		if (!empty($datas)) {
			foreach ($datas as $val) {
				list($ip1, $ip2, $ip3, $ip4) = explode(".", $val);
				$tmp_ip[] = "('".$ip1."','".$ip2."','".$ip3."','".$ip4."')";
			}
			$values = implode(",", $tmp_ip);
			if (!empty($tmp_ip)) {
				$pdb->Execute("INSERT INTO {$tb_prefix}ipbanned (ip1,ip2,ip3,ip4) VALUES ".$values);
			}
		}
	}
	if (!empty($_POST['data']['forbid_word'])) {
		$datas = $string->txt2array($_POST['data']['forbid_word']);
		if (!empty($datas)) {
			foreach ($datas as $val) {
				list($wd1, $wd2) = explode("=", $val);
				$tmp_word[] = "('".$wd1."','".$wd2."')";
			}
			$values = implode(",", $tmp_word);
			if (!empty($values)) {
				$pdb->Execute("INSERT INTO {$tb_prefix}words (title,replace_to) VALUES ".$values);
			}
		}
	}
	if ($_POST['data']['setting1']['welcome_msg']==1 || $_POST['data']['setting1']['welcome_msg']==2) {
		if (!empty($_POST['data']['welcome_msg_title'])) {
			$_POST['data']['setting1']['welcome_msg_title'] = $_POST['data']['welcome_msg_title'];
		}
		if (!empty($_POST['data']['welcome_msg_content'])) {
			$_POST['data']['setting1']['welcome_msg_content'] = $_POST['data']['welcome_msg_content'];
		}
	}
	$updated = $setting->replace($_POST['data']['setting1'], 1);
	$updated = $setting->replace($_POST['data']['setting']);
	if($updated){
		$cache->writeCache("setting", "setting");
		$cache->writeCache("setting1", "setting1");
		pheader("location:setting.php?do=register");
	}else {
		flash();
	}
}
if (isset($_POST['save_cache'])) {
	$updated = $setting->replace($_POST['data']['setting']);
	if($updated){
		$cache->writeCache("setting", "setting");
		pheader("location:setting.php?do=cache");
	}
}
if (isset($_POST['save_mail'])) {
	$updated = $setting->replace($_POST['data']['setting']);
	if($updated){
		$cache->writeCache("setting", "setting");
		pheader("location:setting.php?do=email");
	}
}
function edit_function($data){
	if (empty($data) && !is_array($data)) {
		return;
	}
	$configfile = PHPB2B_ROOT. 'configs'.DS.'config.inc.php';
	$configfiles = file_get_contents($configfile);
	$configfiles = trim($configfiles);
	foreach($data as $key=>$val){
		$pattern[$key] = "/[$]".$key."\s*\=\s*.*?;/is";
		$replacement[$key] = "\$".$key." = ".$val.";";
		if ($key == "subdomain_support") {
			if ($val==1) {
				$replacement[$key] = "\$".$key." = '".$data['subdomain']."';";
			}else{
				$replacement[$key] = "\$".$key." = ".$val.";";
			}
		}
	}
	$configfiles = preg_replace($pattern, $replacement , $configfiles);
	if(file_put_contents($configfile, $configfiles)){
		return true;
	}else{
		return false;
	}
}
if (isset($_POST['save_functions'])) {
	$rs = ''; 
	$data = $_POST['data'];
	if($_POST['data']['rewrite_able']==1){
		$htaccess = PHPB2B_ROOT.'examples/.htaccess';
		$files = file_get_contents($htaccess);
		$pattern = "/(http){1}\:\/\/[w]{3}[\.]yourdomain[\.]com[\/]/";
		$replacement = $absolute_uri;
		$file = preg_replace($pattern,$replacement,$files);
		file_put_contents(PHPB2B_ROOT.'.htaccess',$file);
		copy(PHPB2B_ROOT.'examples/httpd.ini',PHPB2B_ROOT.'httpd.ini');
		}else{
			@unlink(PHPB2B_ROOT.'.htaccess');
			@unlink(PHPB2B_ROOT.'httpd.ini');
		}
		if($_POST['data']['subdomain_support']==1&&$_POST['data']['subdomain']!=''){
		$subdomain = $_POST['data']['subdomain'];
		if(file_exists(PHPB2B_ROOT.'.htaccess')){
		$htaccess = PHPB2B_ROOT.'.htaccess';
		$files = file_get_contents($htaccess);
		$pattern = "/[\.]yourdomain[\.]com/";
		$replacement = $subdomain;
		$file = preg_replace($pattern,$replacement,$files);
		file_put_contents(PHPB2B_ROOT.'.htaccess',$file);
		}else{
		$htaccess = PHPB2B_ROOT.'examples/.htaccess';
		$files = file_get_contents($htaccess);
		$pattern = "/[\.]yourdomain[\.]com/";
		$replacement = $subdomain;
		$file = preg_replace($pattern,$replacement,$files);
		file_put_contents(PHPB2B_ROOT.'.htaccess',$file);
		}
		}
	$updated = edit_function($data);
	if($updated){
		
		flash("success");
	}else{
		flash();
	}
}
setvar("item", $item);
template($tpl_file);
?>