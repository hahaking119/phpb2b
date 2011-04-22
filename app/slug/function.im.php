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
 * @version $Id: function.im.php 438 2009-12-26 13:48:41Z steven $
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
	echo $output;
}
?>