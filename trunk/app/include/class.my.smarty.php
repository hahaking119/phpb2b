<?php
/**
 * Note : The Software shall be used for Good, not Evil.
 * PHPB2B - As an open source b2b program.
 *
 * Permission is hereby granted to use this version of the library under the
 * following license:
 *
 * --
 * Copyright (c) 2006-2009 Ualink (http://www.phpb2b.com/)
 *
 * All rights granted under this License are granted for the term of copyright on 
 * the Program, and are irrevocable provided the stated conditions are met. This 
 * License explicitly affirms your unlimited permission to run the unmodified Program. 
 * The output from running a covered work is covered by this License only if the 
 * output, given its content, constitutes a covered work.
 * This License acknowledges your rights of fair use or other equivalent, as provided
 * by copyright law.
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * --
 *
 * @package phpb2b
 * @copyright 2009 Ualink <phpb2b@hotmail.com> (http://www.phpb2b.com/)
 * @license http://www.opensource.org/licenses/gpl-license.php GPL License
 * @created Mon Jun 22 16:07:56 CST 2009
 * @link http://sourceforge.net/projects/php-b2b/
 * @version $Id: class.my.smarty.php 488 2009-08-15 13:38:40Z stevenchow811 $
 */
require(SMARTY_DIR . "Smarty.class.php");
class MySmarty extends Smarty {

	var $app_dirname;
	var $inc_path_sign;
	var $default_tpl_dirname = "";
	var $media_dir;
	var $tmp_dir;


	function MySmarty($inc_path="./",$app_dir_name="app")
	{
		global $ua_sm_compile_dir;
		$this->Smarty();
		if(!empty($inc_path)) $this->setIncPath($inc_path);
		if(!empty($app_dir_name)) $this->setAppDir($app_dir_name);
		$NowPathArray = explode($app_dir_name,str_replace("\\","/",dirname(__FILE__))) ;
		$AppDir = $NowPathArray[0].$app_dir_name;
		$TmpDir = $NowPathArray[0]."data/tmp";
		$this->setIncPath($inc_path);
		$this->plugins_dir[] = $AppDir."/plugins/";
		$this->template_dir = $inc_path."templates/";
		$this->media_dir = $inc_path."images/";
		if(empty($ua_sm_compile_dir)){
			$this->compile_dir = $TmpDir."/templates_c/";
		}else{
			$comp_d = $TmpDir."/templates_c/".$ua_sm_compile_dir;
			if(!file_exists($comp_d)) @mkdir($comp_d);
			$this->compile_dir =$comp_d;
		}
		//$this->config_dir = $AppDir."/configs/";
		$this->cache_dir = $TmpDir."/templates_cache/";
		$this->left_delimiter = "<{";
		$this->right_delimiter = "}>";
		$this->caching = false;
		$this->debugging   = false;
		//$this->force_compile = true;
		//$this->load_filter('pre','chpath');
	}

	function setAppDir($dirname)
	{
		$this->app_dirname = $dirname;
	}

	function getAppDir()
	{
		return $this->app_dirname;
	}

	function setIncPath($inc_path){
		$this->inc_path_sign = $inc_path;
	}

	function getIncPath()
	{
		return $this->inc_path_sign;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $file_name
	 * @param unknown_type $content
	 * @param 是否自动循环产生静态文件 $htmlcache
	 * @return boolean，是，则操作htmlcache表
	 */
	function MakeHtmlFile($file_name, $content = "", $cache_check = false, $cache_php = "index.php")
	{
		global $htmlcache;
		global $_GET, $ua_user;
		if(!uaStrCompare(md5(AUTH_KEY), $_GET['token'])){
			goto(URL."message.php?message=".urlencode(sprintf(lgg("token_error"), $file_name)));
		}
		unset($ua_user);
		if(!$fp = fopen($file_name, "w")){
			die(sprintf(lgg("file_open_error"), $file_name));
			return false;
		}
		if(!fwrite($fp, $content)){
			die(sprintf(lgg("file_wt_error"), $file_name));
			return false;
		}
		fclose($fp);
		chmod($file_name,0666);
		if ($cache_check) {
			$htmlcache->updateCacheTime($cache_php);
			if(STATIC_HTML_LEVEL>0) goto($file_name);else {
				goto($_SERVER['PHP_SELF']);
			}
		}
		return true;
	}

	function getRelativePath()
	{
		//../../index.html
		global $_GET, $theme_name;
		$paths = array();
		$currentRelativePath = $this->getIncPath();
		if (isset($_GET['action']) && ($_GET['action'])=="html") {
			if($currentRelativePath=="./") $currentRelativePath = "../";
			elseif($currentRelativePath=="../") $currentRelativePath = "../../";
			$paths['CSS_PATH'] = $paths['JS_PATH'] = $paths['INC_PATH'] = $currentRelativePath;
			$paths['tpl_img_path'] = $currentRelativePath."images/";
			$paths['member_tpl_path'] = $currentRelativePath."templates/";
			$paths['attachment_dir'] = $currentRelativePath."attachment/";
			$paths['attachment_url'] = URL."attachment/";
		}else {
			$paths['CSS_PATH'] = $paths['JS_PATH'] = $paths['INC_PATH'] = $currentRelativePath;
			$paths['tpl_img_path'] = $this->media_dir;
			$paths['member_tpl_path'] = $currentRelativePath."templates/";
			$paths['attachment_dir'] = $currentRelativePath."attachment/";
			$paths['attachment_url'] = URL."attachment/";
		}
		return $paths;
	}

	function getAbsolutePath()
	{
		global $theme_name;
		$paths = array();
		$currentRelativePath = substr(URL, 0, -1);
		$paths['CSS_PATH'] = $paths['JS_PATH'] = $paths['INC_PATH'] = $paths['media_path'] = $currentRelativePath."/";
		$paths['tpl_img_path'] = URL."images/";
		$paths['attachment_dir'] = $currentRelativePath."attachment/";
		$paths['attachment_url'] = URL."attachment/";
		return $paths;
	}
}
?>