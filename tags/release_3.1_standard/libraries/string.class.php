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
 * @version $Id: string.class.php 462 2009-12-27 03:20:41Z steven $
 */
class Strings extends PbObject
{
	var $name;
	var $string;
	
	function Strings()
	{
		
	}
	
	function txt2array($data)
	{
		$datas = explode("\r\n", $data);
		$tmp_str = array();
		if (!empty($datas)) {
			foreach ($datas as $val) {
				$tmp_str[] = $val;
			}
			return $tmp_str;
		}else{
			return false;
		}
	}
	
	function txt2file($data)
	{
		$datas = trim(preg_replace("/(\s*(\r\n|\n\r|\n|\r)\s*)/", "\r\n", $data));
		return $datas;
	}
}
?>