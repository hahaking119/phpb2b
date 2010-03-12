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
 * @since PHPB2B v 2.5.0
 * @link http://phpb2b.com
 * @package phpb2b
 * @version $Id: session.class.php 420 2009-12-26 13:37:06Z cht117 $
 */
class PbSessions {
	var $save_handler = "php";//memcache,mysql,apc
	var $security = "high";//high,medium,low
	var $lifetime = 1440;
	var $id;
	var $time;
	var $sesskey;
	var $expiry;
	var $last_activity;
	var $expireref;
	var $save_path;

    function PbSessions($save_path = '') {
    	global $_PB_CACHE;
		$iniSet = function_exists('ini_set');
		$this->save_path = $save_path;
		if (empty($_SESSION)) {
			if ($iniSet && !empty($_PB_CACHE['setting']['session_savepath'])) {
				if (isset($_SERVER['HTTPS'])) {
					ini_set('session.cookie_secure', 1);
				}
				//Todo:
				//ini_set('session.use_cookies', 1);
				//ini_set('session.cookie_lifetime', $this->lifetime);
				if($this->save_path) {
					ini_set('session.save_path', $this->save_path);
				}elseif (defined("DATA_PATH")){
					session_save_path(DATA_PATH. "tmp".DS);
				}
			}
		}
		if (headers_sent()) {
			if (empty($_SESSION)) {
				$_SESSION = array();
			}
			return false;
		} elseif (!isset($_SESSION)) {
			session_cache_limiter ("must-revalidate");
			session_start();
			header ('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');
			return true;
		} else {
			session_start();
			return true;
		}
    }
}
?>