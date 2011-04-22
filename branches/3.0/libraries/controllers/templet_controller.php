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
 * @version $Id: templet_controller.php 426 2009-12-26 13:44:16Z cht117 $
 */
class Templet extends PbController {
	var $name = "Templet";
	var $skin_dir = "skins";
	var $info_filename = "info.inc.php";
	var $type;
	
	function _construct(){

	}
	
	function install($entry)
	{
		$dir = PHPB2B_ROOT. $this->skin_dir.'/';
		$tpldir = realpath($dir.'/'.$entry);
		$_this = & Templets::getInstance();
		if (is_dir($tpldir) && file_exists($tpldir.'/'.$this->info_filename)) {
			require($tpldir.'/'.$this->info_filename);
			$_this->params['data']['name'] = $entry;
			$_this->params['data']['title'] = $theme_title;
			$_this->params['data']['description'] = $theme_description;
			$_this->params['data']['author'] = $theme_author;
			$_this->params['data']['directory'] = $this->skin_dir."/".$entry."/";
			$_this->params['data']['type'] = "user";
			$_this->save($_this->params['data']);
		}
	}
	
	function uninstall($id)
	{
		$_this = & Templets::getInstance();
		$_this->del($id);
	}
	
	function getTemplate(){
		$_this = & Templets::getInstance();
		/*已安装*/
		$installed = $_this->getInstalled();
		/* 未安装 */
		$not_installed = $this->getBuilt();
		/* 所有的 */
		$all = array_merge($installed, $not_installed);
		return $all;
	}
	
	function getBuilt(){
		$built = $temp = array();
		$_this = & Templets::getInstance();
		$installed = $_this->getInstalled();
		foreach($installed as $key=>$val){
			$temp[] = $val['name'];
		}
		$dir = PHPB2B_ROOT. $this->skin_dir.'/';
		$template_dir = dir($dir);
		while($entry = $template_dir->read())  {
			$tpldir = realpath($dir.'/'.$entry);
			if((!in_array($entry, array('.', '..', '.svn'))) && (!in_array($entry, $temp)) && is_dir($tpldir)) {
				if(file_exists($tpldir ."/".$this->info_filename)){
					require($tpldir ."/".$this->info_filename);
				}
				$built[] = array(
				'name' => $entry,
				'title' => $theme_title,
				'available' => 0,
				'directory' => $this->skin_dir.'/'.$entry.'/',
				'author' => $theme_author,
				'picture' => URL.$this->skin_dir.'/'.$entry."/screenshot.jpg",
				);
			}
		}
		return $built;
	}
}
?>