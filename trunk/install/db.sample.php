<?php
if(!defined('IN_PHPB2B')) exit('Not A Valid Entry Point');
include_once(SOURCE_PATH . 'adodb/adodb.inc.php');
$db_links = array('dbhost' => '%UALINK_SETUP_DBHOST%','dbuser' => '%UALINK_SETUP_DBUSER%','dbpass' => '%UALINK_SETUP_DBPASS%','dbname'=> '%UALINK_SETUP_DBNAME%');
$g_db = &NewADOConnection('mysql');
$tb_prefix	= "%UALINK_SETUP_DBPREFIX%";
if(!$g_db or empty($g_db)) die("ERROR IN CONNECT TO DB: <u>" . $g_db->ErrorMsg() . "</u>");
$connected = $g_db->PConnect($db_links['dbhost'],$db_links['dbuser'],$db_links['dbpass'],$db_links['dbname']);
if(!$connected or empty($connected)) die("ERROR IN CONNECT TO DB : <u>" . $g_db->ErrorMsg() . "</u>");
#%UALINK_SETUP_SETNAMES%
?>