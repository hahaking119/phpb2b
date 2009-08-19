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
 * @created Mon Jun 22 16:07:40 CST 2009
 * @link http://sourceforge.net/projects/php-b2b/
 * @version $Id: ualink_object.php 426 2009-06-22 14:04:32Z stevenchow811 $
 */
class UaObject{
	/**
	 * get the mysql version
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