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
 * @version $Id: album.php 481 2009-12-28 01:05:06Z steven $
 */
if(!defined('IN_PHPB2B')) exit('Not A Valid Entry Point');
uses("album");
$album = new Albums();
$joins[] = "LEFT JOIN {$tb_prefix}attachments a ON a.id=Album.attachment_id";
$result = $album->findAll("a.title,a.description,Album.id,a.attachment as thumb", $joins, "Album.member_id='".$member->info['id']."'", "Album.id desc");
if (!empty($result)) {
	$count = count($result);
	for($i=0; $i<$count; $i++){
		$result[$i]['image'] = URL. pb_get_attachmenturl($result[$i]['thumb'], '', 'small');
		$result[$i]['middleimage'] = URL. pb_get_attachmenturl($result[$i]['thumb']);
	}
}
setvar("Items", $result);
$space->render("album");
?>