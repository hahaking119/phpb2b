<?php
//session save handler
$options['table'] = $tb_prefix."sessions";
include_once(SOURCE_PATH . 'adodb/session/adodb-session.php');
ADOdb_Session::config("mysql", $db_links['dbhost'], $db_links['dbuser'], $db_links['dbpass'], $db_links['dbname'],$options);
session_start();
?>