<?php
/**
 * Note : The Software shall be used for Good, not Evil.
 * PHPB2B - As an open source b2b program.
 *
 * Permission is hereby granted to use this version of the library under the
 * following license:
 *
 * --
 * Copyright (c) 2006-2009 Ualink (http://www.phpb2b.com/)
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
 * @package phpb2b
 * @copyright 2009 Ualink <phpb2b@hotmail.com> (http://www.phpb2b.com/)
 * @license http://www.opensource.org/licenses/gpl-license.php GPL License
 * @created Sun Sep 13 10:52:56 CST 2009
 * @link http://sourceforge.net/projects/php-b2b/
 * @version $Id$
 */

function uaMailTo($to_address, $to_name, $subject, $body, $redirect_url = null)
{
    global $charset, $g_db, $setting, $_SETTINGS;
    require_once(INC_PATH."phpmailer/class.phpmailer.php");
    $mail = new PHPMailer();
    $result = false;
    $mail_set = array();
    $mail_set['mail_sendtype'] = $g_db->GetOne("select valued from ".$setting->getTable()." where variable='mail_sendtype'");

    $mail_set['mail_from'] = $g_db->GetOne("select valued from ".$setting->getTable()." where variable='mail_from'");
    $mail_set['mail_fromname'] = $g_db->GetOne("select valued from ".$setting->getTable()." where variable='mail_fromname'");
    if ($mail_set['mail_sendtype']==2) {
        $mail_set['smtp_servername'] = $g_db->GetOne("select valued from ".$setting->getTable()." where variable='smtp_servername'");
        $mail_set['smtp_port'] = $g_db->GetOne("select valued from ".$setting->getTable()." where variable='smtp_port'");
        $mail_set['smtp_ifauth'] = $g_db->GetOne("select valued from ".$setting->getTable()." where variable='smtp_ifauth'");
        $mail_set['smtp_username'] = $g_db->GetOne("select valued from ".$setting->getTable()." where variable='smtp_username'");
        $mail_set['smtp_userpass'] = $g_db->GetOne("select valued from ".$setting->getTable()." where variable='smtp_userpass'");
    	$mail->IsSMTP(); // telling the class to use SMTP
    	$mail->Host       = $mail_set['smtp_servername']; // SMTP server
    	$mail->Port       = $mail_set['smtp_port'];
    	if($mail_set['smtp_ifauth']) $mail->SMTPAuth = true; // 启用SMTP验证功能
    	$mail->Username = $mail_set['smtp_username']; // 邮局用户名(请填写完整的email地址)
    	$mail->Password = $mail_set['smtp_userpass']; // 邮局密码
    }else{
        $mail->IsMail();
    }
    $mail->IsHTML(true);
	$mail->CharSet = $charset; // 这里指定字符集！
	$mail->Encoding = "base64";
	$mail->From     = $mail_set['smtp_username'];
	$mail->FromName = (empty($mail_set['mail_fromname']))? $_SETTINGS['sitename'] : $mail_set['mail_fromname'];
	$mail->Subject = $subject;
	$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
	$mail->MsgHTML($body);
	$mail->AddAddress($to_address, $to_name);
	$result = $mail->Send();
	if(!empty($redirect_url)){
	    header("Location: ".$redirect_url);
	}else{
	    return $result;
	}
}

?>