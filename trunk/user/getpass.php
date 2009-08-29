<?php
$inc_path = "../";
require($inc_path."global.php");
uses("member", "setting");
$setting = new Settings();
$member = new Members();
if (isset($_POST['get_password']) && !empty($_POST['login_name'])) {
	$login_name = trim($_POST['login_name']);
	$useremail = trim($_POST['user_email']);
	if(!checkEmail($useremail)){
		setvar("ERRORS", lgg("wrong_email_format"));
		setvar("postLoginName", $login_name);
	}else{
		$ifexists = $member->checkUserExist($login_name);
		$email_exists = $g_db->GetOne("select username from ".$member->getTable()." where email='".$useremail."'");
		if(!$ifexists || empty($ifexists)){
			setvar("ERRORS",lgg('member_not_exists'));
			setvar("postLoginName", $login_name);
			setvar("postUserEmail", $useremail);
		}
		if(!$email_exists || empty($email_exists)){
			setvar("ERRORS", lgg("wrong_email_data"));
		}
			$memberinfo = $g_db->GetRow("select id,email,firstname,lastname from ".$tb_prefix."members where username='$login_name'");
			if(ua_checkEmail($memberinfo['email'])){
        		if ($ifexists  && !empty($email_exists)) {
				$new_passwd = getRadomStr(6);
				$new_passwd_md5 = md5($new_passwd);
				$body = $mail->getFile($inc_path.'templates/'.$theme_name.'/element.getpass.html');
				$body             = str_replace("[field:username]", $login_name, $body);
				$body             = str_replace("[field:newpassword]", $new_passwd, $body);
				$body             = str_replace("[field:sitename]", $_SETTINGS['sitename'], $body);
				$body             = str_replace("[field:sitetitle]", $_SETTINGS['sitetitle'], $body);
				$body             = str_replace("[field:fulldate]", date("Y-m-d"), $body);
				$body             = str_replace("[field:siteurl]", URL, $body);
				$sended = uaMailTo($memberinfo['email'], $login_name, sprintf(lgg("your_new_email"), $login_name, $_SETTINGS['sitename']), $body);
				unset($_POST);
				if(!$sended)
				{
				   alert(sprintf(lgg("email_send_false"), $mail->ErrorInfo), true);
				}else{
					$sql = "update ".$member->getTable()." set userpass='".$new_passwd_md5."' where id=".$memberinfo['id']." and status='1'";
					$g_db->Execute($sql);
					alert(urlencode(lgg("get_passwd_success")), true);
				}
			}else {
				setvar("ERRORS", lgg('get_passwd_false')."！");
			}
		}
	}
}
template($theme_name."/user_getpass");
?>