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
 * @version $Id: instant_message.inc.php 420 2009-12-26 13:37:06Z cht117 $
 */
$qq = array(
'url'=>'http://wpa.qq.com/msgrd?V=1&Uin=%s&Site=%s&Menu=yes',
'src'=>'http://wpa.qq.com/pa?p=1:%s:8'
);
function formatOnlineCode($id, $prim_im = 0)
{
	global $qq;
	switch ($prim_im) {
		case 1:
			return '<a href="'.sprintf($qq['url'], $id, URL).'" title=""><img src="'.sprintf($qq['src'], $id).'" alt="" /></a>';
			break;
		case 2:
			return '<a href="javascript:;" onclick="alert(\''.$id.'\');" title="'.$id.'"><img src="images/im_icq.gif" alt="'.$id.'" /></a>';
			break;	
		case 3:
			return '<a href="javascript:;" onclick="alert(\''.$id.'\');" title="'.$id.'"><img src="images/msn.gif" alt="'.$id.'" /></a>';
			break;
		case 4:
			return '<a href="javascript:;" onclick="alert(\''.$id.'\');" title="'.$id.'"><img src="images/im_yahoo.gif" alt="'.$id.'" /></a>';
			break;		
		case 5:
			return '<a href="javascript:;" onclick="alert(\''.$id.'\');" title="'.$id.'"><img src="images/im_skype.gif" alt="'.$id.'" /></a>';
			break;

		default:
			return '<img src="images/tel.gif" alt="'.$id.'" />';
			break;
	}
}
?>