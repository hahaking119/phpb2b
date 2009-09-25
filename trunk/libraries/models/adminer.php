<?php
 class Adminers extends PbModel {


 	var $name = "Adminer";
 	var $userid;
 	var $username;
 	var $userpass;

 	function Adminers()
 	{

 	}

	function checkUserLogin($uname,$upass)
	{
		$uname = trim($uname);
		$upass = trim($upass);
		$sql = "SELECT id AS UserID,user_name AS LoginName,user_pass AS LoginPass FROM ".$this->getTable()." WHERE user_name='$uname'";
		$tmpUser = $GLOBALS['g_db']->GetRow($sql);
		$true_pass = $tmpUser['LoginPass'];
		if (empty($uname) || empty($upass)){
			return -1;
		}elseif(!$this->checkUserExist($uname)) {
			return -2;
		}elseif (!pb_strcomp($true_pass,md5($upass))){
			return -3;
		}else {
		    $this->userid = $tmpUser['UserID'];
		    $this->username = $tmpUser['LoginName'];
		    $this->userpass = $tmpUser['LoginPass'];
			return true;
		}
	}

	function checkUserExist($uname)
	{
		$uname = trim($uname);
		$sql = "SELECT user_name FROM ".$this->getTable()." WHERE user_name='$uname'";
		$tmp_exists = $GLOBALS['g_db']->GetOne($sql);
		if (!empty($tmp_exists) || $tmp_exists!='') {
			return true;
		}else {
			return false;
		}
	}
}
?>