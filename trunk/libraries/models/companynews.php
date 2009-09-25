<?php
class Companynewses extends PbModel {

 	
 	var $name = "Companynews";
 	var $common_cols = "Companynews.id AS ID,Companynews.title AS Title,Companynews.created AS CreateDate,Companynews.content AS Content";

 	function Companynewses()
 	{
 		
 	}
}
?>