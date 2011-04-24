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
	var $info_filename = "phpb2b_skin_";
	var $info_fileext= ".xml";
	var $type;
	
	function _construct(){

	}
	
	function install($entry)
	{
		global $chinese;
		$dir = PHPB2B_ROOT. $this->skin_dir.'/';
		include(LIB_PATH. 'xml.class.php');
		$tpldir = realpath($dir.'/'.$entry);
		$_this = & Templets::getInstance();
		if (is_dir($tpldir) && file_exists($tpldir .DS.$this->info_filename.$entry.$this->info_fileext)) {
			$xmldata = implode('', file($tpldir .DS.$this->info_filename.$entry.$this->info_fileext));
			$xmldata = $chinese->Convert($xmldata);
			$data = xml2array($xmldata);
			extract($data['Data']);
			$_this->params['data']['name'] = $entry;
			$_this->params['data']['title'] = $title;
			$_this->params['data']['description'] = $description;
			$_this->params['data']['author'] = $author;
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
		$installed = $_this->getInstalled();
		$not_installed = $this->getBuilt();
		$all = array_merge($installed, $not_installed);
		return $all;
	}
	
	function getBuilt(){
		global $chinese;
		$built = $temp = array();
		$_this = & Templets::getInstance();
		$installed = $_this->getInstalled();
		include_once LIB_PATH. 'xml.class.php';
		foreach($installed as $key=>$val){
			$temp[] = $val['name'];
		}
		$dir = PHPB2B_ROOT. $this->skin_dir.'/';
		$template_dir = dir($dir);
		while($entry = $template_dir->read())  {
			$tpldir = realpath($dir.'/'.$entry);
			if((!in_array($entry, array('.', '..', '.svn'))) && (!in_array($entry, $temp)) && is_dir($tpldir)) {
				if(file_exists($tpldir .DS.$this->info_filename.$entry.$this->info_fileext)){
					$xmldata = implode('', file($tpldir .DS.$this->info_filename.$entry.$this->info_fileext));
					$xmldata = $chinese->Convert($xmldata);
					$data = xml2array($xmldata);
					extract($data['Data']);
				}
				$built[] = array(
				'name' => $entry,
				'title' => $title,
				'available' => 0,
				'directory' => $this->skin_dir.'/'.$entry.'/',
				'author' => $author,
				'picture' => URL.$this->skin_dir.'/'.$entry."/screenshot.jpg",
				);
			}
		}
		return $built;
	}
}
?>