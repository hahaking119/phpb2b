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
 * @version $Id: passport.class.php 458 2009-12-27 03:05:45Z steven $
 */
class Passports extends PbObject
{
	var $names;
	var $config;
	var $passport_dir;
	var $passport_path;
	var $db;
	var $table_prefix;

	function __construct()
	{
		$this->Passports();
	}

	function Passports()
	{
		global $pdb, $tb_prefix;
		$this->db =& $pdb;
		$this->table_prefix = $tb_prefix;
		$this->passport_dir = 'passports';
		$this->passport_path = PHPB2B_ROOT. 'api'.DS.'passports'.DS;
	}

	function install($entry)
	{
		$tpldir = realpath($this->passport_path.$entry);
		if (is_dir($tpldir)) {
			$this->params['data']['name'] = $entry;
			$this->params['data']['title'] = strtoupper($entry);
			$this->params['data']['available'] = 1;
			$this->params['data']['created'] = $this->params['data']['modified'] = $_SERVER['REQUEST_TIME'];
			$this->save($this->params['data']);
		}
	}

	function uninstall($id)
	{
		$sql = "DELETE FROM {$this->table_prefix}passports WHERE id=".$id;
		return $this->db->Execute($sql);
	}

	function getPassports(){
		$installed = $this->getInstalled();
		$not_installed = $this->getUninstalled();
		$all = array_merge($installed, $not_installed);
		return $all;
	}

	function getInstalled()
	{
		$sql = "SELECT * FROM {$this->table_prefix}passports WHERE available=1";
		$result = $this->db->GetArray($sql);
		return $result;
	}

	function getUninstalled(){
		$uninstalled = $temp = array();
		$installed = $this->getInstalled();
		foreach($installed as $key=>$val){
			$temp[] = $val['name'];
		}
		$template_dir = dir($this->passport_path);
		while($entry = $template_dir->read())  {
			$tpldir = realpath($this->passport_path.DS.$entry);
			if((!in_array($entry, array('.', '..', '.svn'))) && (!in_array($entry, $temp)) && is_dir($tpldir)) {
				$uninstalled[] = array(
				'name' => $entry,
				'title' => strtoupper($entry),
				'available' => 0,
				);
			}
		}
		return $uninstalled;
	}

	function writeConfig($file_name, $config)
	{
		if(empty($config) || !is_array($config)) return false;
		$pattern = $replacement = array();
		foreach($config as $k=>$v)
		{
			$pattern[$k] = "/define\(\s*['\"]".strtoupper($k)."['\"]\s*,\s*([']?)[^']*([']?)\s*\)/is";
			$replacement[$k] = "define('".$k."', \${1}".$v."\${2})";
		}
		$str = file_get_contents($this->passport_path.$file_name);
		$str = preg_replace($pattern, $replacement, $str);
		return file_put_contents($this->passport_path.$file_name, $str);
	}
	
	function ucenter($username, $password, $email, $action = 'login')
	{
		include_once (API_PATH. 'passports/ucenter/config.inc.php');
		include_once (API_PATH. "passports/ucenter/uc_client/client.php");
		$sql = "SELECT id,title FROM {$this->table_prefix}passports WHERE available=1 AND name='ucenter'";
		$rs = $this->db->GetRow($sql);
		if (empty($rs) || !$rs) {
			return;
		}
		switch ($action) {
			case "login":
				$this->ucLogin($username, $password);
				break;
			case "reg":
				$this->ucRegister($username, $password, $email);
				break;
			default:
				break;
		}
	}

	function ucLogin($username, $password)
	{
		list($uid,$username,$password,$email) = uc_user_login($username,$password);
		if($uid>0){
			$ucsynlogin = uc_user_synlogin($uid);
		}elseif($uid == -1){
			die('通行证：用户不存在,或者被删除');
		}elseif($uid == -2) {
			die('通行证：密码错误');
		}
	}
	function ucRegister($username, $password, $email){
		$uid = uc_user_register($username, $password, $email);
		if($uid <= 0) {
			if($uid == -1) {
				echo '用户名不合法';
			} elseif($uid == -2) {
				echo '包含要允许注册的词语';
			} elseif($uid == -3) {
				echo '用户名已经存在';
			}elseif($uid == -5) {
				echo 'Email 不允许注册';
			} elseif($uid == -6) {
				echo '该 Email 已经被注册';
			}
		}
	}
}
?>