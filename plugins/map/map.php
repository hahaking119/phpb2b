<?php
/*
Plugin Name: map
Plugin URI: 
Description: 
Version: 1.0
Author: PHPB2B
Author URI: http://www.phpb2b.com/
*/
if(!defined('IN_PHPB2B')) exit('Not A Valid Entry Point');
$pb_plugin_name = "map";
/**
 * 处理一些其他操作
 */
if (isset($_POST['save'])) {
	pb_submit_check("pluginvar");//检查提交的必要参数
}elseif(!defined("IN_PBADMIN")){
	//显示模板
	$plugin->display("show");//显示模板文件
}
?>