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
 * @version $Id: pb_object.php 462 2009-12-27 03:20:41Z steven $
 */
class PbObject{
	
	var $params;

	function PbObject() {
	}

	function __construct() {
	}

	function toString() {
		$class = get_class($this);
		return $class;
	}
	
	function writeCache($filename, $inputstr, $extra = "w")
	{
	    $handle = fopen($filename, $extra);
	    if (!$handle) {
	    	return false;
	    }else{
	        $writed = fwrite($handle, $inputstr);
	        if (!$writed) {
	        	return false;
	        }
	    }
	    @fclose($handle);
	    return true;
	}
}
?>