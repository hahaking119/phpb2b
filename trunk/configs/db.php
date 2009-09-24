<?php
if(!defined('IN_PHPB2B')) exit('Not A Valid Entry Point');
include_once(SOURCE_PATH . 'adodb/adodb.inc.php');
$db_links = array('dbhost' => 'localhost','dbuser' => 'root','dbpass' => '123456','dbname'=> 'test');
$g_db = &NewADOConnection('mysql');
$tb_prefix	= "pb_";
if(!$g_db or empty($g_db)) die("ERROR IN CONNECT TO DB: <u>" . $g_db->ErrorMsg() . "</u>");
$connected = $g_db->PConnect($db_links['dbhost'],$db_links['dbuser'],$db_links['dbpass'],$db_links['dbname']);
unset($db_links);
if(!$connected or empty($connected)) die("ERROR IN CONNECT TO DB : <u>" . $g_db->ErrorMsg() . "</u>");
$g_db->Execute("set names 'utf8'");
?>