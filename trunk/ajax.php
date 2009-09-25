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
 * @copyright 2009 PHPB2B <phpb2b@hotmail.com> (http://www.phpb2b.com/)
 * @license http://www.opensource.org/licenses/gpl-license.php GPL License
 * @created Mon Jun 22 16:06:32 CST 2009
 * @link http://sourceforge.net/projects/php-b2b/
 * @version $Id$
 */
if(!defined('IN_PHPB2B')) exit('Not A Valid Entry Point');
function getIndustryList($arg, $name)
{
	global $industry, $theme_name, $industry_templet;
	global $smarty;
	$obj = new xajaxResponse();
	$obj->assign("loadingDIV", "style.display", "block");
	$obj->assign("industryDIV", "innerHTML", $industry->getIndustryPage(intval($arg), strtolower($name), $industry_templet));
	$obj->assign("loadingDIV", "style.display", "none");
	return $obj;
}
function rebuildHTML($page)
{
	global $htmlcache, $cookiepre;
	$obj = new xajaxResponse();
	if (STATIC_HTML_LEVEL>0) {
    	$if_recache = $htmlcache->needRecache($page);
    	if($if_recache){
    		header("Pragma:   no-cache");
    		$url = URL.$page."?action=html&token=".md5(AUTH_KEY)."";
    		$obj->redirect($url);
    	}
    	if(!empty($_COOKIE[$cookiepre.'auth'])){
    		$obj->assign("toolbar", "style.display", "none");
    		$obj->assign("afterLoginDiv", "style.display", "block");
    		$obj->assign("beforeLoginDiv", "style.display", "none");
    	}
    	return $obj;
	}else{
	    return false;
	}

}
function getSubIndustry(){
	return true;
}
?>