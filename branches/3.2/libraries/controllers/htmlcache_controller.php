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
	var $prefix = '';
	var $archiver_dir = 'archiver';
	var $archiver_url = 'archiver/';
	
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
			flash("file_write_error");
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
	
	function write($file_name = null, $created = null)
	{
		global $time_stamp;
		$fp = false;
		//$allowed_file = array("index", "detail");
		//$allowed_params = array("id");
		$seperate = 10;//间隔多长时间更新静态，单位为秒，0表示触发式更新，不自动更新
		if (!file_exists($this->target_path.$file_name)) {
			$content = ob_get_contents();
			$fp = file_put_contents($this->target_path.$file_name, $content);
			return $fp;
		}else{
			//检查是否需要更新了
			$last_create_time = filemtime($this->target_path.$file_name);
			if ($time_stamp<($last_create_time+$seperate)) {
				return;
			}else{
				$content = ob_get_contents();
				$fp = file_put_contents($this->target_path.$file_name, $content);
				return $fp;
			}
		}
	}
}
?>