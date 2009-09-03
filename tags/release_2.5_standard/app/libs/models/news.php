<?php
class Newses extends UaModel {

 	
 	var $name = "News";
 	var $common_cols = "News.id AS NewsId,News.title AS NewsTitle,News.content AS Content,News.created AS NewsCreated,News.type_id AS TypeID,source AS NewsFrom,keywords AS Keywords,clicked AS Click,News.created AS NewsCreated,source AS NewsContent,picture";

 	function Newses()
 	{
 		
 	}
}
?>