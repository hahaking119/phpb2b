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
 * @package phpb2b.app.plugins
 * @copyright 2009 Ualink <phpb2b@hotmail.com> (http://www.phpb2b.com/)
 * @license http://www.opensource.org/licenses/gpl-license.php GPL License
 * @created Mon Jun 22 16:42:06 CST 2009
 * @link http://sourceforge.net/projects/php-b2b/
 * @version $Id$
 */
function smarty_function_newstype($params){
	global $g_db;
	global $smarty, $theme_name, $tb_prefix, $cookiepre;
	$conditions = array();
	$limit = null;
	extract($params);
	require(CACHE_PATH.$cookiepre."newstype.inc.php");
	if (!class_exists("Newstypes")) {
		uses("newstype");
		$newstype = new Newstypes();
	}else{
	    $newstype = new Newstypes();
	}
	if(!empty($id)){
		if(!empty($UL_DBCACHE_NEWSTYPE)){
		    $result = $UL_DBCACHE_NEWSTYPE[$id];
		}else{
		    $result = $g_db->GetOne("select name from {$tb_prefix}newstypes where id=".intval($id));
		}
	}
	if (empty($result)) {
		$result = "Unknown";
	}
	if(!empty($level)){
		$conditions[] = "level=".$level;
	}
	echo $result;
}
?>