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
 * @version $Id: pending.php 416 2009-12-26 13:31:08Z steven $
 */
define('CURSCRIPT', 'pending');
require("libraries/common.inc.php");
require("share.inc.php");
uses("member");
$member = new Members();
$hash = trim($_GET['hash']);
if (empty($hash)) {
	flash("invalid_request", null, 0);
}
$validate_str = rawurldecode(authcode($hash, "DECODE"));
if (empty($validate_str)) {
	flash("invalid_request", null, 0);
}
formhash();
if (!empty($validate_str)) {
	list($tmp_username, $exp_time) = explode("\t", $validate_str);
    if ($exp_time<$time_stamp) {
    	flash("auth_expired", null, 0);
    }
    $user_exists = $member->checkUserExist($tmp_username, true);
    if ($user_exists && isset($_GET['action'])) {
    	switch ($_GET['action']) {
    		case "activate":
    			$result = $member->updateUserStatus($member->info['id']);
    			if ($result) {
    				flash("actived_and_login", "logging.php");
    			}
    			break;
    		case "getpasswd":
    			setvar("username", $member->info['username']);
    			render("getpasswd.reset");
    			break;
    		default:
    			break;
    	}
    }else{
        flash("member_not_exists", null, 0);
    }
}else{
	flash("invalid_request", null, 0);
}
?>