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
 * @version $Id: sendmail.inc.php 462 2009-12-27 03:20:41Z steven $
 */
function pb_sendmail($to_address, $to_name, $subject, $body, $redirect_url = null)
{
    global $charset, $_PB_CACHE;
    require_once(LIB_PATH. "phpmailer/class.phpmailer.php");
    $mail = new PHPMailer();
    $result = false;
    if (!empty($_PB_CACHE['setting']['mail'])) {
    	extract(unserialize($_PB_CACHE['setting']['mail']));
    }
    if ($send_mail == 2) {
    	$mail->IsSMTP();
    	$mail->Host       = $smtp_server;
    	$mail->Port       = $smtp_port;
    	if($smtp_auth) $mail->SMTPAuth = true;
    	$mail->Username = $auth_username;
    	$mail->Password = $auth_password;
    }else{
        $mail->IsMail();
    }
    $mail->IsHTML(true);
	$mail->CharSet = $charset;
	$mail->Encoding = "base64";
	$mail->From     = $mail_from;
	$mail->FromName = (empty($mail_fromwho))? $_PB_CACHE['setting']['site_name'] : $mail_fromwho;
	$mail->Subject = $subject;
	$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
	$mail->MsgHTML($body);
	$mail->AddAddress($to_address, $to_name);
	$result = $mail->Send();
	if ($mail->error_count>0) {
		return false;
	}
	if(!empty($redirect_url)){
	    pheader("Location:".$redirect_url);
	}else{
	    return $result;
	}
}

?>