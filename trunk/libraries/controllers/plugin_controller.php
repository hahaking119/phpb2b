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
 * @version $Id: plugin_controller.php 481 2009-12-28 01:05:06Z steven $
 */
class Plugin extends PbController {
	var $name = "Plugin";
	var $plugin_dir = "plugins";
	var $plugin_path;
	var $info_filename = "info.inc.php";
	var $plugin_name;
	var $need_config = false;
	
	function Plugin($plugin_name = '')
	{
		$this->plugin_path = PHPB2B_ROOT. $this->plugin_dir.DS;
		if (!empty($plugin_name)) {
			$this->plugin_name = $plugin_name;
		}
	}

	function install($entry)
	{
		global $smarty;
		$return = 0;
		$tpldir = realpath($this->plugin_path.$entry);
		$_this = & Plugins::getInstance();
		if (is_dir($tpldir) && file_exists($tpldir.'/'.$this->info_filename)) {
			require($tpldir.'/'.$this->info_filename);
			$_this->params['data']['name'] = $entry;
			$_this->params['data']['available'] = 1;
			$_this->params['data']['title'] = $title;
			$_this->params['data']['description'] = $description;
			$_this->params['data']['copyright'] = $copyright;
			$_this->params['data']['version'] = $version;
			$_this->params['data']['created'] = $_this->params['data']['modified'] = $_this->timestamp;
			$_this->save($_this->params['data']);
			if (file_exists($tpldir.'/template/admin'.$smarty->tpl_ext)) {
				$this->need_config = true;
			}
			$key = $_this->table_name."_id";
			$return = $_this->$key;
		}
		return $return;
	}
	
	function uninstall($id)
	{
		$_this = & Plugins::getInstance();
		$_this->del($id);
	}
	
	function getPlugins(){
		$_this = & Plugins::getInstance();
		$installed = $_this->getInstalled();
		$not_installed = $this->getUninstalled();
		$all = array_merge($installed, $not_installed);
		return $all;
	}
	
	function getUninstalled(){
		$built = $temp = array();
		$_this = & Plugins::getInstance();
		$installed = $_this->getInstalled();
		foreach($installed as $key=>$val){
			$temp[] = $val['name'];
		}
		$template_dir = dir($this->plugin_path);
		while($entry = $template_dir->read())  {
			$tpldir = realpath($this->plugin_path.'/'.$entry);
			if((!in_array($entry, array('.', '..', '.svn'))) && (!in_array($entry, $temp)) && is_dir($tpldir)) {
				if(file_exists($tpldir ."/".$this->info_filename)){
					require($tpldir ."/".$this->info_filename);
					$built[] = array(
					'name' => $entry,
					'title' => $title,
					'version' => $version,
					'available' => 0,
					'copyright' => $copyright,
					'description' => $description,
					);
				}
			}
		}
		return $built;
	}

	function display($file_name)
	{
		global $smarty;
		$tpl_file = $this->plugin_path.$this->plugin_name.DS."template".DS.$file_name.".html";
		return $smarty->fetch($tpl_file, null, null, true);
	}
}
?>