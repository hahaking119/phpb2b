<?php
/*
Plugin Name: 演示的插件
Plugin URI: http://www.phpb2b.com/
Description: 这是一个演示的插件， 显示在前台的图片轮换上技术支持见<a href="http://www.phpb2b.net/">Support Forum</a>.
Version: 1.0.0
Author: steven
Author URI: http://www.ualink.org
*/
if(!defined('IN_PHPB2B')) exit('Not A Valid Entry Point');
/**
 * 处理一些其他操作
 */
if (isset($_POST['save'])) {
	pb_submit_check("pluginvar");//检查提交的必要参数
}elseif(!defined("IN_PBADMIN")){
	//显示模板
	$plugin->display("image_roll");//显示模板文件image_roll(.html)
}
?>