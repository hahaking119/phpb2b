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
 * @version $Id: htmlcache_controller.php 481 2009-12-28 01:05:06Z steven $
 */
class Htmlcache extends PbController {
	var $name = 'Htmlcache';
	var $params;
	var $module;
	var $table;
	var $file_name;
	var $file_ext = '.html';
	var $full_file_name;
	var $tpl_file;
	var $target_path;
	var $prefix = 'phpb2b_';
	
	function Htmlcache()
	{
	}
	
	function MakeHtmlFile($file_name, $content = '', $cache_check = false, $cache_php = 'index.php')
	{
		global $pb_userinfo;
		unset($pb_userinfo);
		if(!$fp = fopen($file_name, "w")){
			die(sprintf(L("file_open_error"), $file_name));
			return false;
		}
		if(!fwrite($fp, $content)){
			die(sprintf(L("file_write_error"), $file_name));
			return false;
		}
		fclose($fp);
		chmod($file_name,0666);
		return true;
	}
	
	function setTargetPath($target_path)
	{
		if (!file_exists($target_path)) {
			pb_create_folder($target_path);
		}
		$this->target_path = $target_path;
	}
	
	function getTargetPath()
	{
		return $this->target_path;
	}
	
	function write()
	{
		$_this =& Htmlcaches::getInstance();
		$content = ob_get_contents();
		$htmls_path = PHPB2B_ROOT."htmls/".date("Y")."/".date("m")."/".date("d")."/";
		$this->setTargetPath($htmls_path);
		if(isset($_GET['id'])) {
			$fp = file_put_contents($this->target_path."offer_detail~id-".$_GET['id'].".html", $content);
			return $fp;
		}else{
			return false;
		}
	}
}
?>