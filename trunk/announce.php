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
 * @version $Id: announce.php 416 2009-12-26 13:31:08Z steven $
 */
define('CURSCRIPT', 'announce');
require("libraries/common.inc.php");
uses("announcement");
$announce = new Announcements();
if (isset($_GET['id'])) {
	$id = intval($_GET['id']);
	$result = $announce->read("subject,message,created", $id);
	if (!empty($result)) {
		$result['message'] = nl2br($result['message']);
		$viewhelper->setTitle($result['subject']);
		$viewhelper->setPosition($result['subject']);
		setvar("item", $result);
		setvar("PageTitle", strip_tags($result['subject']));
		render("announce.detail");
		exit;
	}
}
$result = $announce->findAll("*", null, null, "display_order ASC,id DESC");
$viewhelper->setPosition(L("announce", "tpl"), "announce.php");
setvar("Items", $result);
render("announce");
?>