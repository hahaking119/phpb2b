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
 * @copyright 2009 PHPB2B <phpb2b@hotmail.com> (http://www.phpb2b.com/)
 * @license http://www.opensource.org/licenses/gpl-license.php GPL License
 * @created Mon Jun 22 16:42:34 CST 2009
 * @link http://sourceforge.net/projects/php-b2b/
 * @version $Id: function.im.php 106 2009-09-12 15:11:07Z stevenchow811@163.com $
 */
function smarty_function_im($params){
	global $smarty, $theme_name;
	$output = null;
	$tpl_file = (isset($params['templet']))?"blocks/".$params['templet'].".html":"blocks/im.html";
	extract($params);
	if(isset($params['img'])){
		$linkimage = URL.$params['img'];
	}
	switch ($params['type']){
		case "qq":
			$linkimage = (isset($linkimage))?$linkimage:URL."images/qq_online.jpg";
			$linkurl = "http://wpa.qq.com/msgrd?V=1&Uin=".$params['id']."&Site=".URL."&Menu=yes";
			$output = "<a href=\"".$linkurl."\" title=\"".$params['type'].$params['id']."\"><img src=\"".$linkimage."\" align=\"absmiddle\" border=\"0\" alt=\"".$params['id']."\" /></a>";
			break;
		default:
			$linkimage = (isset($linkimage))?$linkimage:URL."images/msn.gif";
			$linkurl = "http://webmessenger.msn.com/?contact=".$params['id'];
			$output = "<a href=\"".$linkurl."\" title=\"".$params['type'].$params['id']."\"><img src=\"".$linkimage."\" align=\"absmiddle\" border=\"0\" alt=\"".$params['id']."\" /></a>";
			break;
	}
	//$output = $smarty->fetch($theme_name."/".$tpl_file, null, null, false);
	//$output = str_replace(array("[link:title]", "[field:id]", "[img:src]"), array($linkurl, $params['id'], $linkimage), $output);
	echo $output;
}
?>