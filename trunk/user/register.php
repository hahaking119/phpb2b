<?php
$inc_path = "../";
require($inc_path."global.php");
require(SITE_ROOT. './app/configs/db_session.php');
require(INC_PATH .'xajax/xajaxAIO.inc.php');
require($inc_path .APP_NAME. 'include/inc.discuz.php');
require($inc_path .APP_NAME. 'include/inc.phpwind.php');
uses("member","company","membertype","companytype","access","setting", "htmlcache", "industry");
$cfg['reg_time_seperate'] = 3*60;
$cfg['register_type'] = array("close_register", "open_common_reg", "open_invite_reg");
$industry = new Industries();
$htmlcache = new Htmlcaches();
$member = new Members();
$setting = new Settings();
$access = new Accesses();
$membertype = new Membertypes();
$companytype = new Companytypes();
$company = new Companies();
$check_invite_code = false;
$if_set_register_picture = $setting->field("ab", "aa='register_picture'");
$register_type = $setting->field("ab", "aa='register_type'");
$ip_reg_sep = $setting->field("ab", "aa='ip_reg_sep'");
if (!empty($ip_reg_sep)) {
	$cfg['reg_time_seperate'] = $ip_reg_sep*60*60;
}
if ($register_type=="close_register") {
	alert(lgg("site_closed"));
}elseif ($register_type=="open_invite_reg"){
    setvar("IfInviteCode", true);
    $check_invite_code = true;
}
setvar("IfRegisterPicture",intval($if_set_register_picture));
/**xajax**/
$xajax = new xajax();
$xajax->configure('javascript URI', URL."app/source/xajax/");
if (isset($_GET['ob'])) {
	if($_GET['ob'] == "company") $tpl_file = "user_register_company";
	else $tpl_file = "user_register_personal";
}else{
    $tpl_file = "user_register_personal";
}
function uaset($val)
{
	$val = strip_tags(trim($val));
}
function forbidIp($params)
{

}
if(isset($_POST['register'])){
    $is_company = false;
    if ($_POST['register']=="company") {
    	$is_company = true;
    }
	$r_check = false;
	$auth_check = uaStrCompare(strtolower($_POST['login_auth']),strtolower($_SESSION['authnum_session']));
	if ($if_set_register_picture && !$auth_check) {
		session_destroy();
		PB_goto(URL."message.php?message=".urlencode(lgg('auth_error')));
	}else{
	    unset($_SESSION['authnum_session']);
	}
	if ($check_invite_code) {
		//检查邀请码
		$decode_authcode = authcode($_POST['data']['invite_code'], 'DECODE');
		//检查邀请人是否存在
		if (empty($decode_authcode)) {
			alert(lgg('invite_code_error'));
		}
	}
	$member_datas = $_POST['data']['Member'];
	$checked = $member->checkUserExist($member_datas['username']);
	$uip = uaIp2Long($_SERVER['REMOTE_ADDR']);
	if(empty($uip)){
		PB_goto(URL."message.php?message=".urlencode(lgg('sys_error')));
	}
	if($cfg['reg_time_seperate']>($time_stamp-$_SESSION['last_reg_time'])){
		PB_goto(URL."message.php?message=".urlencode(lgg('sys_error')));
	}
	if(!empty($checked)){
		die(lgg('member_exists'));
	}else if (empty($member_datas['memberpass']) || empty($_POST['re_memberpass'])){
		die(lgg('pls_input_password'));
	}else if (empty($member_datas['email'])){
		die(lgg('pls_input_email'));
	}else{
		$vars = null;
		$tmp_username = trim($member_datas['username']);
		$vars['username'] = $tmp_username;
		$vars['userpass'] = md5(trim($member_datas['memberpass']));
		$vars['firstname'] = $member_datas['firstname'];
		$vars['lastname'] = $member_datas['lastname'];
		$vars['depart'] = $member_datas['depart'];
		$vars['position'] = $member_datas['position'];
		$vars['tel'] = $member_datas['tel'];
		$vars['gender'] = $member_datas['gender'];
		$vars['mobile'] = $member_datas['mobile'];
		$vars['address'] = $member_datas['address'];
		$vars['zipcode'] = $member_datas['zipcode'];
		$vars['email'] = $member_datas['email'];
		$vars['created'] = $time_stamp;
		$vars['qq'] = $member_datas['qq'];
		$vars['icq'] = $member_datas['icq'];
		$vars['yahoo'] = $member_datas['yahoo'];
		$vars['msn'] = $member_datas['msn'];
		$vars['reg_ip'] = $uip;
		$default_membertype = $membertype->field("id","if_default=1");
		$vars['user_type'] = $default_membertype;
		$access->primaryKey = "membertype_id";
		$time_limits = $access->read("default_livetime,after_livetime", $default_membertype);
		$vars['service_start_date'] = $time_stamp;
		$vars['service_end_date'] = $access->getExpireTime($time_limits['default_livetime']);
		$vars['user_level'] = ($is_company)?2:1;
		$member_reg_check = $setting->field("ab","aa='regcheck'");
		$member_reg_auth = $setting->field("ab","aa='new_userauth'");
		if($member_reg_check=="1" || $member_reg_auth!=0){
			$vars['status'] = 0;
			$CheckRegisterUser = "&check=1";
		}else{
			$vars['status'] = 1;
		}
		if ($member_reg_auth==1) {
		    $exp_time = $time_stamp+86400;
		    $str = "Please active it through : ".URL."user/pending.php?hash=".authcode($tmp_username."|".$exp_time, "ENCODE");
		    $sended = uaMailTo($vars['email'], $tmp_username, URL, $str);
		}
		array_walk($vars,"uaset");
		$updated =  false;
		$vars['last_login'] = $time_stamp;
		$updated = $member->save($vars);
		if ($updated) {
			uses("stat");
			$stat = new Stats();
			$stat->Add("member");
		}
		if($updated){
			$last_member_id = $g_db->Insert_ID();
			if ($member_reg_check=="0") {
			uaSetLoginSession(array("MemberID"=>$last_member_id,"MemberName"=>$tmp_username,
			"MemberPass"=>$vars['userpass']));
			}
			usetcookie("auth",
			authcode($last_member_id, "ENCODE")."|".
			authcode($tmp_username, "ENCODE")."|".
			authcode($vars['userpass'], "ENCODE")."|".
			authcode($vars['user_type'], "ENCODE")."|".
			authcode($vars['email'], "ENCODE")."|".
			authcode($vars['user_level'], "ENCODE"));
			if($is_company && !empty($_POST['company']['name'])){
				require($inc_path .APP_NAME. 'include/inc.topinyin.php');
				$comp_vars = null;
				$comp_vars['name'] = $_POST['company']['name'];
				$comp_vars['member_id'] = $last_member_id;
				$comp_vars['telcode'] = $_POST['tel']['country'];
				$comp_vars['type_id'] = $_POST['company']['type_id'];
				$comp_vars['link_man'] = $_POST['company']['link_man'];
				$comp_vars['telzone'] = $_POST['tel']['area'];
				$comp_vars['tel'] = $_POST['tel']['number'];
				$comp_vars['created'] = $time_stamp;
				$comp_vars['province_code_id'] = intval($_POST['country_id']);
				$comp_vars['city_code_id'] = intval($_POST['province_id']);
				$comp_vars['industry_id'] = intval($_POST['aindustry']);
				$comp_vars['first_letter'] = getFirstPin($comp_vars['name']);
				array_walk($comp_vars,"uaset");
				$company->save($comp_vars);
				$stat->Add("company");
				if (!empty($_POST['aindustry'])) {
					$industry->updateModelAmount(intval($_POST['aindustry']), "company_amount");
				}
			}
			$gopage = URL.'user/regdone.php?name='.$tmp_username.$CheckRegisterUser;
			if ($forums['switch']==true && ($_POST['join_forum'] == 1))
			{
				if($forums['type']=="discuz"){
					$member_reg = array
					(
					'username'	=> $tmp_username,
					'password'	=> $vars['userpass'],
					'email'		=> $vars['email'],
					'regdate'	=> $time_stamp,
					'regip'		=> $uip,
					'gender'	=> $vars['gender'],
					'qq'	=> $vars['qq'],
					'ICQ'	=> $vars['icq'],
					'msn'	=> $vars['msn'],
					'yahoo'	=> $vars['yahoo'],
					);
					$gopage = DZ_API($member_reg,"login",URL."user/regdone.php?name=".rawurlencode($tmp_username).$CheckRegisterUser);
					PB_goto($gopage);
				}elseif($forums['type']=="phpwind"){
					$member_reg = array
					(
					'username'	=> $tmp_username,
					'time'	=> $time_stamp,
					'password'	=> $vars['userpass'],
					'email'		=> $vars['email'],
					);
					$gopage = PW_API($member_reg,"login",URL."user/regdone.php?name=".rawurlencode($tmp_username).$CheckRegisterUser);
					PB_goto($gopage);
				}
			}
			PB_goto($gopage);
		}
	}
}

function checkName($name)
{
    $obj = new xajaxResponse();
    $tmpUserName = trim($name);
    $errmsg = null;
    if(!empty($tmpUserName))
    {
    	$checked = $GLOBALS['member']->checkUserExist($tmpUserName);
    	if (!eregi("^[_a-zA-Z0-9-]+(\.[_a-z0-9-]+)*$",$tmpUserName)){
    		$errmsg = lgg('wrong_username');
    		$obj->assign("Submit","disabled",true);
    	}elseif(strlen($tmpUserName)<5 || strlen($tmpUserName)>20) {
    		$errmsg = "<img src=\"".URL."images/check_error.gif\"> ".lgg('username_length')."";
    		$obj->assign("Submit","disabled",true);
    	}elseif(is_numeric($tmpUserName)) {
	    	$errmsg = "<img src=\"".URL."images/check_error.gif\"> ".lgg('username_numeric')."";
	    	$obj->assign("Submit","disabled",true);
    	}elseif(!($checked)) {
    		$errmsg = "<img src=\"".URL."images/check_right.gif\">";
    		$obj->assign("Submit","disabled",false);
    	}else{
    		$errmsg = "<img src=\"".URL."images/check_error.gif\"> ".lgg('member_exists')."";
    		$obj->assign("Submit","disabled",true);
    	}
    }else {
    	$errmsg = "<img src=\"".URL."images/check_error.gif\"> ".lgg('pls_input_right_username')."";
    	$obj->assign("Submit","disabled",true);
    }
    $obj->assign("membernameDiv","innerHTML",$errmsg);
    return $obj;
}

function checkMemberEmail($email)
{
    $obj = new xajaxResponse();
    $tmpEmail = trim($email);
    $errmsg = null;
    if(!empty($tmpEmail))
    {
    	$checked = false;
    	$checked = $GLOBALS['member']->field("id", "email='".$tmpEmail."'");
    	if ($checked){
    		$errmsg = "<img src=\"".URL."images/check_error.gif\"> ".lgg('email_exists')."";
    		$obj->assign("Submit","disabled",true);
    	}elseif(!checkEmail($tmpEmail)){
    		$errmsg = "<img src=\"".URL."images/check_error.gif\"> ".lgg('pls_input_email')."";
    		$obj->assign("Submit","disabled",true);
    	}else{
    		$errmsg = "<img src=\"".URL."images/check_right.gif\">";
    		$obj->assign("Submit","disabled",false);
    	}
    }else {
    	$errmsg = "<img src=\"".URL."images/check_error.gif\"> ".lgg('pls_input_email')."";
    	$obj->assign("Submit","disabled",true);
    }
    $obj->assign("memberemailDiv","innerHTML",$errmsg);
    return $obj;
}
function checkCompanyName($name)
{
    $obj = new xajaxResponse();
    $cname = trim($name);
    $errmsg = null;
    if(!empty($cname))
    {
    	$checked = false;
    	$checked = $GLOBALS['company']->field("id", "name='".$cname."'");
    	if ($checked){
    		$errmsg = "<img src=\"".URL."images/check_error.gif\">";
    		$obj->assign("Submit","disabled",true);
    	}else{
    		$errmsg = "<img src=\"".URL."images/check_right.gif\">";
    		$obj->assign("Submit","disabled",false);
    	}
    }else {
    	$errmsg = "<img src=\"".URL."images/check_error.gif\">";
    	$obj->assign("Submit","disabled",true);
    }
    $obj->assign("companynameDiv","innerHTML",$errmsg);
    return $obj;
}
$xajax->register(XAJAX_FUNCTION,  "checkMemberEmail");
$xajax->register(XAJAX_FUNCTION,  "checkName");
$xajax->register(XAJAX_FUNCTION,  "checkCompanyName");
$xajax->processRequest();
setvar('xajax_javascript', $xajax->getJavascript());
/** :~xajax**/
$result = $companytype->findAll("id as CompanytypeId,name as CompanytypeName",$conditions, " id desc", 0,15);
$company_types = array();
foreach ($result as $key=>$val) {
	$company_types[$val['CompanytypeId']] = $val['CompanytypeName'];
}
setvar("CompanyTypes",$company_types);
if (isset($_GET['action']) && $_GET['action']=="html") {
	$smarty->MakeHtmlFile('../htmls/user/'.$tpl_file.'.html',$smarty->fetch($theme_name."/".$tpl_file.".html"), true, $urls['register']);
}
template($theme_name."/".$tpl_file);
?>