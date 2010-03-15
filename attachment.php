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
 * @version $Id: attachment.php 497 2009-12-28 03:38:51Z steven $
 */
define('CURSCRIPT', 'attachment');
require("libraries/common.inc.php");
require("share.inc.php");
if(empty($_GET['id'])){
	$picture_src = URL."images/watermark.png";
}
if (isset($_GET['source'])) {
	$file_source = trim(rawurldecode($_GET['source']));
	$picture_src = URL.$attachment_url.$file_source;
}
setvar("img_src", $picture_src);
render("attachment");
?>