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
 * @version $Id: feedback.php 481 2009-12-28 01:05:06Z steven $
 */
if(!defined('IN_PHPB2B')) exit('Not A Valid Entry Point');
uses("message");
$companymessage = new Messages();
if (isset($_POST['companyid']) && !empty($_POST['feed']) && !empty($pb_user)) {
	$vals = $_POST['feed'];
	$vals['created'] = $time_stamp;
	$vals['status'] = 0;
	$vals['from_member_id'] = $pb_user['pb_userid'];
	$vals['cache_from_username'] = $pb_user['pb_username'];
	$vals['to_member_id'] = $member->info['id'];
	$vals['cache_to_username'] = $member->info['username'];
	if($companymessage->save($vals)){
		flash("feedback_already_submit");
	}else {
		flash();
	}
}
$space->render("feedback");
?>