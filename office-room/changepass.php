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
 * @version $Id: changepass.php 428 2009-12-26 13:45:57Z steven $
 */
require("../libraries/common.inc.php");
require("room.share.php");
if (isset($_POST['do'])) {
	$do = trim($_POST['do']);
	if($do == "checkpasswd"){
		pb_submit_check('oldpass');
		$OldPassCheck = $member->checkUserLogin($_SESSION['MemberName'],$_POST['oldpass']);
		if ($OldPassCheck>0) {
			$vals = array();
			$vals['userpass'] = $member->authPasswd(trim($_POST['newpass']));
			if (!empty($_POST['question']) && !empty($_POST['answer'])) {
				$vals['question'] = $_POST['question'];
				$vals['answer'] = $_POST['answer'];
			}
			$result = $member->save($vals, "update", $_SESSION['MemberID']);
			flash("success");
		}else {
			flash('old_pwd_error');
		}
	}
}
template("changepass");
?>