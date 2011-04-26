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
 * @version $Id: friendlink.php 416 2009-12-26 13:31:08Z steven $
 */
define('CURSCRIPT', 'friendlink');
require("libraries/common.inc.php");
require("share.inc.php");
uses("setting", "message", "friendlink");
$pms = new Messages();
$friendlink = new Friendlinks();
$setting = new Settings();
if (isset($_POST['do']) && !empty($_POST['friendlink'])) {
	pb_submit_check('friendlink');
	$data = $_POST['friendlink'];
	$result = false;
	$data['status'] = 0;
	$data['created'] = $data['modified'] = $time_stamp;
	$result = $friendlink->save($data);
	if ($result) {
		$pms->SendToAdmin('', array(
		"title"=>$data['title'].L("apply_friendlink"),
		"content"=>$data['title'].L("apply_friendlink")."\n".$_POST['data']['email']."\n".$data['description'],
		));
		$smarty->flash('wait_apply', URL);
	}
}
formhash();
render("friendlink");
?>