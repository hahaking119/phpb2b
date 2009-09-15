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
 * @created Mon Jun 22 16:07:47 CST 2009
 * @link http://sourceforge.net/projects/php-b2b/
 * @version $Id: func.global.php 426 2009-06-22 14:04:32Z stevenchow811 $
 */
	function showDbError()
	{
		global $g_db;
		die("ADODB ERROR : <font color=red face='Arial'>" . $g_db->ErrorMsg()) . "</font>";
	}

	function da($arr_str)
	{
		echo "<pre>";
		print_r($arr_str);
		echo "</pre>";
	}

	function uaStrCompare($str1,$str2)
	{
		if (strcmp(trim($str1),trim($str2)) == 0) {
			return true;
		}else {
			return false;
		}
	}

	function getRadomStr($len=6,$recycle=1){

		$str.= 'ABCDEFGHJKMNPQRSTUVWXYabcdefghjkmnpqrstuvwxy';
		$str.= '123456789';

		$str = str_repeat($str,$recycle);
		return substr(str_shuffle($str),0,$len);
	}

	function setvar($name,$var)
	{
		global $smarty;
		$smarty->assign($name,$var);
	}

	function uaAssign($names)
	{
		global $smarty;
		if (is_array($names)) {
			foreach ($names as $smt_key=>$smt_val) {
				$smarty->assign($smt_key,$smt_val);
			}
		}
	}

	/**
	* @ifbackward if create back btn
	*/
	function PB_goto($url = "./index.php", $result = false, $msg = null, $otherparams = null, $ifbackward = true)
	{
		if ($result) {
			$url.="?result=success";
			if(isset($msg)) $url.="&message=".urlencode($msg);
		}
		if(isset($_SERVER['HTTP_REFERER'])){
			$forward = urlencode($_SERVER['HTTP_REFERER']);
			if(strpos($url, ".php?")) $url.="&return_forward=".$forward;
			else $url.="?return_forward=".$forward;
		}
		if(!empty($otherparams)){
			$url.="&".$otherparams;
		}
		echo "<script language=\"javascript\">window.open('".$url."','_self');</script>";
		exit;
	}

	function flash($url, $refer = null, $message=null, $result = 1, $pause=null, $back_list = null, $back_add = null)
	{
		if (empty($refer)) {

			$gourl[]="refer=".$_SERVER['REQUEST_URI'];
		}else{
			$refer = str_replace("./", "", $refer);
			$gourl[]="refer=".$refer;
		}
		if (!empty($message)) {
			$gourl[]="message=".urlencode($message);
		}
		if ($result) {
			$gourl[]="result=1";
		}
		if (!is_null($pause)) {
			$gourl[]="pause=".$pause;
		}
		if (!is_null($back_list)) {
			$gourl[]="listpage=".$back_list;
		}
		if (!is_null($back_add)) {
			$gourl[]="addpage=".$back_add;
		}
		$url_params = implode("&", $gourl);
		if(substr($url_params,0,1)=="&") $url_params = substr_replace($url_params, "", 0, 1);
		$url.= "?".$url_params;
		echo "<script language=\"javascript\">window.open('".$url."','_self');</script>";
		exit;
	}

	function alert($msg, $if_back = false, $back_url = "")
	{
		global $smarty, $theme_name, $_GET;
		$alertMsg = urldecode($msg);
		if ($if_back) {
			$backward_url = (empty($back_url))?$_SERVER['HTTP_REFERER']:trim($back_url);
			$smarty->assign("BackwardUrl", $backward_url);
		}
		$smarty->assign("alertMsg", str_replace(" ", "-", $alertMsg));
		$smarty->assign("alertKeyword", str_replace(array(" ", "_", "-"), ",", $alertMsg));
		$return = $smarty->display($theme_name."/flash.html");
		echo $return;
		exit;
	}

	function createFolder($path)
	{
	   if (!file_exists($path))
	   {
	    createFolder(dirname($path));
	    mkdir($path, 0777);
	   }
	}

	function template($filename = null, $ext = ".html", $lang = array())
	{
		global $smarty;
		$return = false;
		$return = $smarty->display($filename.".html");
		return $return;
	}

	function ua_checkEmail($email){
		$return = false;
		if(strstr($email, '@') && strstr($email, '.')){
			if(eregi("^([_a-z0-9]+([\._a-z0-9-]+)*)@([a-z0-9]{2,}(\.[a-z0-9-]{2,})*\.[a-z]{2,3})$", $email)){
				$return = true;
			}
		}
		return $return;
	}

	function uaSetLoginSession($session_vars)
	{
		if (is_array($session_vars)) {
			foreach ($session_vars as $session_key=>$session_val) {
				$_SESSION[$session_key] = $session_val;
			}
		}
	}

	function uaSetLoginCookie($cookie_vars)
	{
		if (is_array($cookie_vars)) {
			foreach ($cookie_vars as $cookie_key=>$cookie_val) {
				$_COOKIE[$cookie_key] = $cookie_val;
			}
		}
	}

	function ua_checkLogin($username,$userpass,$url = null)
	{
		global $member,$company, $time_stamp, $forums, $inc_path;
		global $g_db;
		$keep_online = 3600;
		$forward = (isset($_GET['referer'])) ? urldecode($_GET['referer']):URL;
		if(!empty($url)) $forward = urldecode($url);
		$checked = $member->checkUserLogin($username,$userpass);
		$tmp_memberinfo = array();
		if ($checked > 0) {
			$tmp_memberinfo = $member->info;
			uaSetLoginSession(array("MemberName"=>$username,"MemberID"=>$tmp_memberinfo['id'],"MemberPass"=>md5($userpass)));
			usetcookie("auth",
			authcode($tmp_memberinfo['id'], "ENCODE")."|".
			authcode($username, "ENCODE")."|".
			authcode(md5($userpass), "ENCODE")."|".
			authcode($tmp_memberinfo['user_type'], "ENCODE")."|".
			authcode($tmp_memberinfo['email'], "ENCODE")."|".
			authcode($tmp_memberinfo['user_level'], "ENCODE")."|".
			authcode($keep_online, "ENCODE")."|".
			authcode($tmp_memberinfo['credit_point'], "ENCODE"));
			$member_info = array
			(
			'time'		=> $time_stamp,
			'username'	=> $username,
			'password'	=> md5($userpass),
			'email'		=> $tmp_memberinfo['email'],
			);
			if($tmp_memberinfo['user_level'] == 9) {
				$member_info['isadmin'] = 1;
				$_SESSION['is_admin'] = $username;
			}
			if(!empty($tmp_memberinfo['office_redirect'])){
				if($tmp_memberinfo['office_redirect']!=0){
					switch ($tmp_memberinfo['office_redirect']) {
						case 1:
							$forward = URL;
						break;
						case 2:
							$forward = URL."room/";
						break;
						case 3:
							$forward = URL."room/trade.php";
						break;
						case 4:
							$forward = URL."room/message.php?type=in";
						break;
						default:
							$forward = URL."room/";
						break;
					}
				}
			}
			if($forums['switch']==true){
                require($inc_path .APP_NAME. 'include/inc.discuz.php');
                require($inc_path .APP_NAME. 'include/inc.phpwind.php');
				if($forums['type']=="discuz"){
					return true;
				}elseif($forums['type']=="phpwind") {
					$member_info['uid'] = $tmp_memberinfo['id'];
					$member_info['cktime'] = $keep_online;
					$goto_page = PW_API($member_info,"login",$forward);
					header("Location:".$goto_page);
					exit;
				}
			}else{
				$goto_page = $forward;
				PB_goto($goto_page);
				exit;
			}
			unset($tmp_memberinfo);
		}else{
			$errors = true;
		}
		return $checked;
	}

	/**
	* @para string $var cookie
	* @para string $value cookie
	* @para int $life
	* @para int $prefix cookie
	*
	*/

	function usetcookie($var, $value, $life = 0, $prefix = 1) {
			global $cookiepre, $cookiepath, $time_stamp;
			$cookiedomain = '';
			setcookie(($prefix ? $cookiepre : '').$var, $value,
					$life ? $time_stamp + $life : 0, $cookiepath,
					$cookiedomain, $_SERVER['SERVER_PORT'] == 443 ? 1 : 0);
	}

	function uclearcookies() {
		usetcookie('auth', '', -86400 * 365);
	}

	function fileext($filename) {
		return substr(($t=strrchr($filename,'.'))!==false?".".$t:'',1);
	}

	function uaHtmlSpecialChars($string) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = uhtmlspecialchars($val);
			}
		} else {
			$string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4})|[a-zA-Z][a-z0-9]{2,5});)/', '&\\1',
			str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string));
		}
		return $string;
	}

	function uaGetClientIP()
	{
		if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
			$onlineip = getenv('HTTP_CLIENT_IP');
		} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
			$onlineip = getenv('HTTP_X_FORWARDED_FOR');
		} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
			$onlineip = getenv('REMOTE_ADDR');
		} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
			$onlineip = $_SERVER['REMOTE_ADDR'];
		}
		preg_match("/[\d\.]{7,15}/", $onlineip, $onlineipmatches);
		$onlineip = $onlineipmatches[0] ? $onlineipmatches[0] : 'unknown';
		return $onlineip;
	}

	function ulAddSlashes($string) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = ulAddSlashes($val);
			}
		} else {
			$string = addslashes($string);
		}
		return $string;
	}

	function uaConvertComma($str){
		$str = strip_tags($str);
		if(strpos($str, "，")) $str = str_replace("，",",",$str);
		if(strpos($str, ",")) {
			$str = preg_replace("/\s*/","",$str);
			$str = str_replace(",", " ", $str);
		}else{
			$str = trim($str);
			$str = preg_replace("/\s(?=\s)/", "", $str);
			$str = preg_replace("/[\n\r\t]/", "", $str);
		}
		$str = str_replace(" ", ",", $str);
		return $str;
    }

    function uaProcessTableCol($colname)
    {
    	$new_column_name = null;
    	if (strstr($colname, "_")) {
    		$tmp_col = explode("_", $colname);
    		foreach ($tmp_col as $val) $new_column_name.=ucfirst(strtolower($val));
    	}else {
    		$new_column_name = ucfirst(strtolower($colname));
    	}
    	return $new_column_name;
    }

    if (!function_exists('getmicrotime')) {
    /**
     * Returns microtime for execution time checking
     *
     * @return float Microtime
     */
    	function getmicrotime() {
    		list($usec, $sec) = explode(' ', microtime());
    		return ((float)$usec + (float)$sec);
    	}
    }

    function uaGetAbsoluteUrl()
    {
		if ( isset( $_SERVER['HTTPS'] ) && ( strtolower( $_SERVER['HTTPS'] ) != 'off' ) ) {
			$ul_protocol = 'https';
		}else{
			$ul_protocol = 'http';
		}
    	return $ul_protocol."://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
    }

    function uaGetHost($http = true)
    {
		if ( isset( $_SERVER['HTTPS'] ) && ( strtolower( $_SERVER['HTTPS'] ) != 'off' ) ) {
			$ul_protocol = 'https';
		}else{
			$ul_protocol = 'http';
		}
    	if($http) {
			$return = $ul_protocol."://".$_SERVER['HTTP_HOST'];
		} else {
			$return = $_SERVER['HTTP_HOST'];
		}
    	return $return;
    }

    function uatrim(&$val)
	{
		$val = strip_tags(trim($val));
	}

    function uaGetOs() {
    	$os = $_SERVER['HTTP_USER_AGENT'];
    	if(strpos($os,"Windows")) $os="Windows";
    	elseif(strpos($os,"unix")) $os="Unix";
    	elseif(strpos($os,"linux")) $os="Linux";
    	elseif(strpos($os,"SunOS")) $os="SunOS";
    	elseif(strpos($os,"BSD")) $os="FreeBSD";
    	elseif(strpos($os,"Mac")) $os="Mac";
    	else $os="Other";
    	return $os;
    }

	function SplitKeywords($params)
	{
		extract($params);
		$links = null;
		$keywords = explode(",",$params['keyword']);
		foreach ($keywords as $key=>$val) {
			$links.="<a href='".URL."tag.php?keyword=".urlencode(strip_tags($val))."'>".$val."</a>&nbsp;";
		}
		return $links;
	}

	function loadDivSubIndustry($sid, $li = null)
	{
		global $industry;
		$li = (is_null($li))?1:intval($li);
		$subs = $industry->getAllIndustry("AND Industry.parentid=".$sid);
		$model_subs = $industry->formatSubIndusty($subs,$li);
	    $obj = new xajaxResponse();
	    $obj->addAssign("divSubIndustry","innerHTML", $industry->subHeader.$model_subs.$industry->subFooter);
	    return $obj->getXML();
	}

	function uaFormatPositionPath($position_path)
	{
		$position_name = null;
		if(is_array($position_path)){
			foreach ($position_path as $key=>$val) {
				$position_name.="<a href=\"".$val['url']."\">".$val['name']."</a>";
			}
		}
		return $position_name;
	}

	function uses() {
		$args = func_get_args();
		foreach($args as $arg) {
			$class_name = strtolower($arg);
			require(LIB_PATH . "controllers/".$class_name. '_controller.php');
			require(LIB_PATH . "models/".$class_name. '.php');
		}
	}

	function uaIp2Long($ip)
	{
		return sprintf("%u",ip2long($ip));
	}


	function uaLog($action_name = null,  $type_id = 1, $member_id = null, $action_result = true)
	{
		global $log;
		$vals = array();

		return true;
	}

	function plugin(){
		return false;
	}

	function checkEmail($str)
	{
		if (eregi("^[0-9a-z][_.0-9a-z-]{0,31}@([0-9a-z][0-9a-z-]{0,30}[0-9a-z]\.){1,4}[a-z]{2,4}$", $str))
		return true;
		else
		return false;
	}

   function isUrl($inputUrl){
       $regUrl = "^(http://)?((localhost)|(([0-9a-z][0-9a-z_-]+.){1,3}[a-z]{2,4}))$";
       $resultUrl = ereg($regUrl,$inputUrl);
       if ($resultUrl == 1)
           {return "true";}
       else
           {return "false";}
   }



	function editor($input_name, $input_value, $smartyOutput, $toolbar = "Default")
	{

		$editor = new FCKeditor($input_name) ;
		$editor->BasePath   = "./fckeditor/";
		$editor->ToolbarSet = $toolbar;
		$editor->Width      = "100%";
		$editor->Height     = "200";
		$editor->Value      = $input_value;
		$oFCKeditor->InstanceName = $smartyOutput;
		$FCKeditor = $editor->CreateHtml();
		setvar($smartyOutput, $FCKeditor);
	}


	function stripSeqSpace($string)
	{
		$str = preg_replace('#\s+#', ' ', trim($string));
		return $str;
	}

	function getMemberInfo()
	{
		global $cookiepre;
		$ua_member = null;
		if (!empty($_COOKIE[$cookiepre."auth"])) {
			$ua_member_str = explode("|", $_COOKIE[$cookiepre."auth"]);
			$ua_member['id'] 			= authcode($ua_member_str[0], "DECODE");
			$ua_member['username']		= authcode($ua_member_str[1], "DECODE");
			$ua_member['userpass']		= authcode($ua_member_str[2], "DECODE");
			$ua_member['user_type']		= authcode($ua_member_str[3], "DECODE");
			$ua_member['email']			= authcode($ua_member_str[4], "DECODE");
			$ua_member['user_level']	= authcode($ua_member_str[5], "DECODE");
			if(isset($ua_member_str[6])) $ua_member['keep_online']	= authcode($ua_member_str[6], "DECODE");
			if(isset($ua_member_str[7])) $ua_member['credit_point']	= authcode($ua_member_str[7], "DECODE");
		}else {

		}
		return $ua_member;
	}

	function authcode($string, $operation = "ENCODE", $key = '') {

		$key = md5($key ? $key : AUTH_KEY);
		$key_length = strlen($key);

		$string = $operation == 'DECODE' ? base64_decode($string) : substr(md5($string.$key), 0, 8).$string;
		$string_length = strlen($string);

		$rndkey = $box = array();
		$result = '';

		for($i = 0; $i <= 255; $i++) {
			$rndkey[$i] = ord($key[$i % $key_length]);
			$box[$i] = $i;
		}

		for($j = $i = 0; $i < 256; $i++) {
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}

		for($a = $j = $i = 0; $i < $string_length; $i++) {
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp;
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		}

		if($operation == 'DECODE') {
			if(substr($result, 0, 8) == substr(md5(substr($result, 8).$key), 0, 8)) {
				return substr($result, 8);
			} else {
				return '';
			}
		} else {
			return str_replace('=', '', base64_encode($result));
		}

	}

	function dir_writeable($dir) {
		if(!is_dir($dir)) {
			@mkdir($dir, 0777);
		}
		if(is_dir($dir)) {
			if($fp = @fopen("$dir/ua_sample.txt", 'w')) {
				@fclose($fp);
				@unlink("$dir/ua_sample.txt");
				$writeable = true;
			} else {
				$writeable = false;
			}
		}
		return $writeable;
	}

	function splitIndustryAmount($params)
	{
		extract($params);
		$str = $params['amount_str'];
		$tmp1 = explode("|", $str);
		$type = $params['amount_type'];
		$tmp1 = explode("|", $str);
		if ($type=="sum") {
			return intval(array_sum($tmp1));
		}else{
			$type_t = intval($type)-1;
			return $tmp1[$type_t];
		}
	}

	function lgg($msg, $extra = true)
	{
	    global $app_lang;
	    if($extra){
	        require(BASE_DIR."app/lang/".$app_lang.".inc.php");
	        $return = $ul_lang[strtolower($msg)];
	    }else{
	        $return = $msg;
	    }
	    unset($ul_lang);
	    return $return;
	}

function utf_substr($str,$len, $left = true)
{
    for($i=0;$i<$len;$i++)
    {
        $temp_str=substr($str,0,1);
        if(ord($temp_str) > 127)
       {
            $i++;
            if($i<$len)
           {
               $new_str[]=substr($str,0,3);
               $str=substr($str,3);
           }
       }
       else
      {
         $new_str[]=substr($str,0,1);
         $str=substr($str,1);
      }
    }
    if($left) return join($new_str)."...";
	else return join($new_str);
}

function checkip($minIpAddress, $maxIpAddress) {
    global $_SERVER;
    $onlineip = empty($_SERVER['REMOTE_ADDR']) ? getenv('REMOTE_ADDR') : $_SERVER['REMOTE_ADDR'];
    $longip = ip2long($onlineip);
    if(isInRange($longip, $minIpAddress, $maxIpAddress)) {
        die("IP FOBIDDEN!");
    }
}

function isInRange($x, $min, $max) {
    return $x >= $min && $x <= $max;
}

function L($key, $type = "msg")
{
	global $arrMessage, $arrTemplate;
	if ("msg" == $type) {
	    $return = $arrMessage['_'.$key];
	}else{
	    $return = $arrTemplate['_'.$key];
	}
	return (!empty($return))?$return:"Unkown String";
}
?>