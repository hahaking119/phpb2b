<?php
$inc_path = "./";
require("global.php");
uses("member", "setting");
$setting = new Settings();
$member = new Members();
if (isset($_POST['get_password']) && !empty($_POST['login_name'])) {
	$login_name = trim($_POST['login_name']);
	$useremail = trim($_POST['user_email']);
	if(!pb_check_email($useremail)){
		setvar("ERRORS", lgg("wrong_email_format"));
		setvar("postLoginName", $login_name);
	}else{
		$ifexists = $member->checkUserExist($login_name);
		$email_exists = $g_db->GetOne("SELECT username FROM ".$member->getTable()." WHERE email='".$useremail."'");
		if(!$ifexists || empty($ifexists)){
			setvar("ERRORS",lgg('member_not_exists'));
			setvar("postLoginName", $login_name);
			setvar("postUserEmail", $useremail);
		}
		if(!$email_exists || empty($email_exists)){
			setvar("ERRORS", lgg("wrong_email_data"));
		}
			$memberinfo = $g_db->GetRow("SELECT id,email,firstname,lastname FROM {$tb_prefix}members WHERE username='$login_name'");
			if(pb_check_email($memberinfo['email'])){
        		if ($ifexists  && !empty($email_exists)) {
				$new_passwd = pb_radom(6);
				$new_passwd_md5 = md5($new_passwd);
				$body = $smarty->fetch($theme_name.'/emails/user_get_pass.html');
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
					$sql = "UPDATE ".$member->getTable()." SET userpass='".$new_passwd_md5."' WHERE id=".$memberinfo['id']." AND status='1'";
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