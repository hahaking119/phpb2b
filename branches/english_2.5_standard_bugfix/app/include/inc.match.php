<?php
//被屏蔽的email地址%email%
//被屏蔽的网址%url%
function email_match ($target_str, $isFind=false, $isTotal=false){
	$pattern = "/[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)*/";
	return get_match_result($target_str, $pattern, $isFind);
}
function url_match ($target_str, $isFind=false, $isTotal=false){
	$pattern = "/(http|https|ftp)\:\/\/([a-zA-Z0-9]+\.)?([a-zA-Z0-9]+\.[a-zA-Z0-9]+)*/";
	return get_match_result($target_str, $pattern, $isFind);
}

function phone_match ($target_str, $isFind=false, $isTotal=false){
	$pattern = "/((\(?\d{3,4}\))?|(\d{3,4}-)?)\d{7,8}/";
	return get_match_result($target_str, $pattern, $isFind);
}

function get_match_result($target_str, $pattern, $isFind) {
	//是否提取出匹配目标
	if ($isFind == true) {
		preg_match($pattern, $target_str, $result);
	}else{
		$result = preg_match($pattern, $target_str);
	}
	return $result;
}
?>