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
 * ����һЩ��������
 */
if (isset($_POST['save'])) {
	pb_submit_check("pluginvar");//����ύ�ı�Ҫ����
}elseif(!defined("IN_PBADMIN")){
	//��ʾģ��
	$plugin->display("show");//��ʾģ���ļ�
}
?>