<?php
/**
 * Note : The Software shall be used for Good, not Evil.
 * PHPB2B - As a open source b2b program.
 *
 * Permission is hereby granted to use this version of the library under the
 * following license:
 *
 * --
 * Copyright (c) 2006-2009 PHPB2B (http://www.phpb2b.com/)
 *
 * All rights granted under this License are granted for the term of copyright on
 * the Program, and are irrevocable provided the stated conditions are met. This
 * License explicitly affirms your unlimited permission to run the unmodified Program.
 * The output from running a covered work is covered by this License only if the
 * output, given its content, constitutes a covered work.
 * This License acknowledges your rights of fair use or other equivalent, as provided
 * by copyright law.
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * --
 *
 * @package phpb2b.user
 * @copyright 2009 PHPB2B <phpb2b@hotmail.com> (http://www.phpb2b.com/)
 * @license http://www.opensource.org/licenses/gpl-license.php GPL License
 * @created Mon Aug 24 12:18:01 CST 2009
 * @link http://sourceforge.net/projects/php-b2b/ PHPB2B On SourceForge
 * @version $Id$
 */
/**
 * 用户注册激活。
 */
$inc_path = "../";
require($inc_path."global.php");
uses("member");
$member = new Members();
$hash = trim($_GET['hash']);
if (empty($hash)) {
	die("Please reset hash value.");
}
$validate_str = authcode($hash, 'DECODE');
/**
 * 判断时间是否过期
 */
if (!empty($validate_str)) {
    $tmpValidateStr = explode("|", $validate_str);
    if ($tmpValidateStr[1]<$time_stamp) {
    	die("Your auth has expired");
    }
    $tmpUserName = $tmpValidateStr[0];
    $userExists = $member->checkUserExist($tmpUserName);
    if ($userExists) {
    	$sql = "update ".$member->getTable()." set status='1' where username='".$tmpUserName."' and status='0'";
    	$result = $g_db->Execute($sql);
    	if ($result) {
    		alert("Activity successed please login", true, URL."user/logging.php");
    	}
    }else{
        die("User not exists");
    }
}else{
	die("Invalid Request");
}
//判断随机码， 密钥是否符合
//判断用户名是否存在
?>