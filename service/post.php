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
 * @version $Id: post.php 416 2009-12-26 13:31:08Z steven $
 */
define('CURSCRIPT', 'post');
require("../libraries/common.inc.php");
require("../share.inc.php");
uses("service");
$service = new Services();
if (isset($_POST['save_service']) && !empty($_POST['service']['content'])) {
	pb_submit_check('service');
	$vals = array();
	$vals['status'] = 0;
	$vals['member_id'] = 0;
	$vals['title'] = L("comments_and_suggestions", "tpl");
	$vals['content'] = $_POST['service']['content'];
	if(isset($_POST['service']['nick_name'])) $vals['nick_name'] = $_POST['service']['nick_name'];
	$vals['email'] = $_POST['service']['email'];
	$vals['type_id'] = 1;
	$vals['created'] = $time_stamp;
	$vals['user_ip'] = pb_get_client_ip();
	if($service->save($vals)){
		flash('thanks_for_advise', URL);
	}else {
		flash();
	}
}else{
	flash("pls_enter_your_advise", "index.php");
}
?>