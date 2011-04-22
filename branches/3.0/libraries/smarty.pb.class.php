<?php
/**
 * Description ...
 *
 * PHP versions 4 and 5
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
 * @version $Id: smarty.pb.class.php 462 2009-12-27 03:20:41Z steven $
 */
require(LIB_PATH . "smarty/Smarty.class.php");
class MySmarty extends Smarty {
	var $flash_layout;
	var $tpl_ext = '.html';

	function MySmarty()
	{
		global $debug;
		$this->Smarty();
		if (isset($debug)) {
			switch ($debug) {
				case 1:
					error_reporting(E_ALL & ~E_DEPRECATED);
					if(function_exists('ini_set')) {
						ini_set('display_errors', 1);
					}
					break;
				case 2:
					error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
					break;
				case 3:
					error_reporting(E_ALL);
					break;
				case 4:
					error_reporting(E_ALL);
					$GLOBALS['pdb']->debug = true;
					break;
				case 5:
					error_reporting(E_ALL);
					$GLOBALS['pdb']->debug = true;
					$this->debugging   = true;
					break;
				default:
					error_reporting(0);
					if(function_exists('ini_set')) {
						ini_set('display_errors', 0);
					}
					break;
			}
		}
		$this->plugins_dir[] = APP_PATH."slug".DS;
		$this->template_dir = PHPB2B_ROOT ."templates".DS;
		$this->compile_dir = DATA_PATH."templates_c".DS;
		$this->cache_dir = DATA_PATH."templates_cache".DS;
		$this->left_delimiter = "<{";
		$this->right_delimiter = "}>";
		$this->caching = false;
	}
	
	function setCompileDir($compile_dir = '')
	{
		if(!empty($compile_dir)){
			$comp_d = $this->compile_dir.$compile_dir;
			if(!file_exists($comp_d)) pb_create_folder($comp_d);
			$this->compile_dir =$comp_d;
		}
	}
	
	function getRelativePath()
	{
		global $theme_name;
		$paths = array();
		$currentRelativePath = "";
		$paths['theme_img_path'] = $currentRelativePath."templates/".$theme_name."/";
		$paths['attachment_dir'] = $currentRelativePath."attachment/";
		$paths['attachment_url'] = URL."attachment/";
		return $paths;
	}
	
	function flash($message_code, $url, $pause = 1) {
		$images = array("failed.png", "success.png", "notice.png");
		$styles = array("error", "true");
		if (empty($message_code) || !$message_code || $message_code=="failed") {
			$image = $images[0];
			$message = L('action_failed');
			$style = $styles[0];
		}elseif($message_code=="success" or true===$message_code or strstr("success", $message_code)){
			$image = $images[1];
			$style = $styles[1];
			$message = L("success");
		}else{
			$image = $images[2];
			$style = null;
			$message = L($message_code);
		}
		$this->assign('action_img', $image);
		$this->assign('action_style', $style);
		$this->assign('url', $url);
		$this->assign('message', $message);
		if($pause!=0){
			$this->assign('redirect', $this->redirect($url, $pause));
		}
		$this->assign('page_title', strip_tags($message));
		template($this->flash_layout);
		exit();
	}
	
	function redirect($url, $pause) {
	
		return "<script>\n".
		"function redirect() {\nwindow.location.replace('$url');\n}\n".
		"setTimeout('redirect();', ".($pause*1000).");\n".
		"</script>";
	}
}
?>