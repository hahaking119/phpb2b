<?php
/**
 * Note : The Software shall be used for Good, not Evil.
 * PHPB2B - As an open source b2b program.
 *
 * Permission is hereby granted to use this version of the library under the
 * following license:
 *
 * --
 * Copyright (c) 2006-2009 PHPB2B (http://www.phpb2b.com/)
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
 * @subpackage app.libs
 * @copyright 2009 PHPB2B <phpb2b@hotmail.com> (http://www.phpb2b.com/)
 * @license http://www.opensource.org/licenses/gpl-license.php GPL License
 * @created Mon Jun 22 16:07:40 CST 2009
 * @link http://sourceforge.net/projects/php-b2b/
 * @version $Id$
 */
class PbObject{

	function PbObject() {
		$args = func_get_args();
		if (method_exists($this, '__destruct')) {
			register_shutdown_function (array(&$this, '__destruct'));
		}
		call_user_func_array(array(&$this, '__construct'), $args);
	}

	/**
	* Class constructor
	*/
	function __construct() {
	}

	/**
	 *
	 * @return string The name of this class
	 * @access public
	 */
	function toString() {
		$class = get_class($this);
		return $class;
	}

	/**
	 *
	 * @param array $properties
	 * @return void
	 * @access protected
	 */
	function _set($properties = array()) {
		if (is_array($properties) && !empty($properties)) {
			$vars = get_object_vars($this);
			foreach ($properties as $key => $val) {
				if (array_key_exists($key, $vars)) {
					$this->{$key} = $val;
				}
			}
		}
	}
	
	/**
	 *
	 * @return Mysql version.
	 */
	function getMysqlVersion()
	{
		global $g_db;
		$v = $g_db->GetOne("SELECT VERSION()");
		return $v;
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