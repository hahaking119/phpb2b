<?php
$inc_path = "../";
require($inc_path."global.php");
uses("member","memberlog","company","setting");
require($inc_path .APP_NAME. 'include/inc.discuz.php');
require($inc_path .APP_NAME. 'include/inc.phpwind.php');
require(SITE_ROOT. './app/configs/db_session.php');
$company = new Companies();
$setting = new Settings();
$memberlog = new Memberlogs();
$member = new Members();
$referer = "";
if(isset($_GET['referer'])) $referer = urldecode($_GET['referer']);
$_SERVER['HTTP_REFERER'] = $referer ? $referer : $_SERVER['REQUEST_URI'];
$ua_user = getMemberInfo();
$if_set_login_picture = $setting->field("ab", "aa='login_picture'");
setvar("IfLoginPicture",intval($if_set_login_picture));
if(isset($_POST['loginbtn'])){
	$back_forward = null;
	$auth_check = uaStrCompare(strtolower($_POST['login_auth']),strtolower($_SESSION['authnum_session']));
	if (!$auth_check && $if_set_login_picture) {
		session_destroy();
		setvar("LoginError",lgg('wrong_validate'));
	}elseif(!empty($_POST['login_name']) && !empty($_POST['login_pass'])){
		unset($_SESSION['authnum_session']);
		$tmpUserName = $_POST['login_name'];
		$tmpUserPass = $_POST['login_pass'];
		if(!empty($_POST['forward'])){
			$back_forward = $_POST['forward'];
		}
		$checked = ua_checkLogin($tmpUserName,$tmpUserPass, $back_forward);
        //UC LOGIN 通过接口判断登录帐号的正确性，返回值为数组
        if($forums['type']=="discuz"){
	        list($uid, $username, $password, $email) = uc_user_login($tmpUserName, $tmpUserPass);
	        if($uid > 0) {
	            //生成同步登录的代码
	            $ucsynlogin = uc_user_synlogin($uid);
	            echo '登录成功'.$ucsynlogin.'<br><a href="'.$referer.'">继续</a>';
	            exit;
	        } elseif($uid == -1) {
	            echo '用户不存在,或者被删除';
	        } elseif($uid == -2) {
	            echo '密码错';
	        } else {
	            echo '未定义';
	        }
        }
        //END UC LOGIN
		if ($checked > 0) {
			$errmsg = "";
		}elseif ($checked == (-2) ) {
			$errmsg = lgg('member_not_exists');
		}elseif ($checked == (-3)) {
			$errmsg = lgg('login_pwd_false');
		}elseif ($checked == (-4)) {
			$errmsg = lgg('member_checking');
		}else {
			$errmsg = lgg('login_false');
		}
		setvar("LoginError",$errmsg);
	}
}

function ua_htmlspecialchars($string) {
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = ua_htmlspecialchars($val);
		}
	} else {
		$string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4})|[a-zA-Z][a-z0-9]{2,5});)/', '&\\1',
		str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string));
	}
	return $string;
}

function ua_referer($default = '') {
	global $referer;
	$indexname = URL;
	$default = empty($default) ? $indexname : '';
	$referer = ua_htmlspecialchars($referer);
	if(!preg_match("/(\.php|[a-z]+(\-\d+)+\.html)/", $referer) || strpos($referer, 'logging.php')) {
		$referer = $default;
	}
	return $referer;
}
if(isset($_GET['action']) && ($_GET['action'] == "logout")){
	$member_out = null;
	$referer = ua_referer();
	uclearcookies();
	if (isset($_GET['fr'])) {
		if ($_GET['fr']=="cp") {
			usetcookie("uladmin", "");
		}
	}
	session_destroy();
	if($forums['switch']==true){
		if($forums['type']=="discuz"){
            $member_out = array
            (
            'username'	=> $_SESSION['MemberName'],
            'password'	=> $_SESSION['MemberPass'],
            'email'		=> $ua_user['email'],
            'cookietime'=> $ua_user['keep_online']
            );
            $gopage = URL;
            /**UC OUT**/
            $ucsynlogout = uc_user_synlogout();
            echo '退出成功'.$ucsynlogout.'<br><a href="'.$referer.'">继续</a>';
            exit;
            /**END UC OUT**/
		}elseif($forums['type']=="phpwind"){
			$member_out = array
			(
				'username'	=> $_SESSION['MemberName'],
				'password'	=> $_SESSION['MemberPass'],
				'email'		=> $ua_user['email'],
				'cookietime'=> $ua_user['keep_online']
			);
			$gopage = PW_API($member_out,"quit",$referer);
		}
	}else{
		$gopage = $referer;
	}
	if (!empty($_GET['forward'])) {
		PB_goto($_GET['forward']);
	}else{
		header("Location:".$gopage);
	}
	exit;
}
template($theme_name."/user_logging");
?>