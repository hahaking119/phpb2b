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
 * @subpackage phpb2b.libs
 * @copyright 2009 Ualink <phpb2b@hotmail.com> (http://www.phpb2b.com/)
 * @license http://www.opensource.org/licenses/gpl-license.php GPL License
 * @created Mon Jun 22 16:07:31 CST 2009
 * @link http://sourceforge.net/projects/php-b2b/
 * @version $Id: ualink_controller.php 25 2009-08-28 01:46:55Z stevenchow811@163.com $
 */
class UaController extends UaObject
{
	var $current_li = null;

	function orangeConditions($conditions){
		$tmp_c = null;
		if(is_array($conditions)){
			$tmp_c = implode(" and ", $conditions);
		}else if(is_string($conditions)){
			$tmp_c = $conditions;
		}
		return $tmp_c;
	}

	function generateList($result)
	{
		$return  = null;
		foreach ($result as $key=>$val) {
			$return[$val['OptionId']] = $val['OptionName'];
		}
		return $return;
	}

	function getClientIP() {
		if (env('HTTP_X_FORWARDED_FOR') != null) {
			$ipaddr = preg_replace('/,.*/', '', env('HTTP_X_FORWARDED_FOR'));
		} else {
			if (env('HTTP_CLIENT_IP') != null) {
				$ipaddr = env('HTTP_CLIENT_IP');
			} else {
				$ipaddr = env('REMOTE_ADDR');
			}
		}

		if (env('HTTP_CLIENTADDRESS') != null) {
			$tmpipaddr = env('HTTP_CLIENTADDRESS');

			if (!empty($tmpipaddr)) {
				$ipaddr = preg_replace('/,.*/', '', $tmpipaddr);
			}
		}
		return trim($ipaddr);
	}

	function stripWhitespace($str) {
		$r = preg_replace('/[\n\r\t]+/', '', $str);
		return preg_replace('/\s{2,}/', ' ', $r);
	}

	function env($key) {

		if ($key == 'HTTPS') {
			if (isset($_SERVER) && !empty($_SERVER)) {
				return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on');
			} else {
				return (strpos(env('SCRIPT_URI'), 'https://') === 0);
			}
		}

		if (isset($_SERVER[$key])) {
			return $_SERVER[$key];
		} elseif (isset($_ENV[$key])) {
			return $_ENV[$key];
		} elseif (getenv($key) !== false) {
			return getenv($key);
		}

		if ($key == 'DOCUMENT_ROOT') {
			$offset = 0;
			if (!strpos(env('SCRIPT_NAME'), '.php')) {
				$offset = 4;
			}
			return substr(env('SCRIPT_FILENAME'), 0, strlen(env('SCRIPT_FILENAME')) - (strlen(env('SCRIPT_NAME')) + $offset));
		}
		if ($key == 'PHP_SELF') {
			return str_replace(env('DOCUMENT_ROOT'), '', env('SCRIPT_FILENAME'));
		}
		return null;
	}
}
?>