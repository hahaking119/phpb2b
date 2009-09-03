<?php 
defined('IN_UALINK') or exit('Permission Denied');

function StrCode($string,$action='ENCODE'){
	$key	= substr(md5($_SERVER["HTTP_USER_AGENT"].AUTH_KEY),8,18);
	$string	= $action == 'ENCODE' ? $string : base64_decode($string);
	$len	= strlen($key);
	$code	= '';
	for($i=0; $i<strlen($string); $i++){
		$k		= $i % $len;
		$code  .= $string[$i] ^ $key[$k];
	}
	$code = $action == 'DECODE' ? $code : base64_encode($code);
	return $code;
}

function PW_API($userdb, $action, $forward, $db_hash = AUTH_KEY)
{
	global $time_stamp, $forums;
	$userdb_encode = '';
	foreach($userdb as $key=>$val)
	{
		$userdb_encode .= $userdb_encode ? "&$key=$val" : "$key=$val";
	}
	$userdb_encode = str_replace('=', '', StrCode($userdb_encode));
	$verify = md5($action.$userdb_encode.$forward.$db_hash);
	if($forums['switch']==true && $forums['type']=="phpwind"){
	$gopage = $forums['url']."passport_client.php?action=$action&userdb=".rawurlencode($userdb_encode)."&forward=".rawurlencode($forward)."&verify=".rawurlencode($verify);
	}else {
		$goto_page = $forward;
	}
	return $gopage;
}
?>