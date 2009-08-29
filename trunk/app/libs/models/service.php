<?php
 class Services extends UaModel {


 	var $name = "Service";
 	var $common_cols = "Service.id AS ID,Service.title AS Title,Service.content AS Content,created AS CreateTime,nick_name as NickName,revert_content AS Revert,adminer_user_name AS RevertName,revert_date AS RevertDate";

 	function Services()
 	{

 	}
 }