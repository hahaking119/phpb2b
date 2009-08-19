<?php
class Producttypes extends UaModel {

 	
 	var $name = "Producttype";
 	var $common_cols = "Producttype.id AS ID,Producttype.name AS Name,Producttype.created AS CreateDate,Producttype.level AS Level";

 	function Producttypes()
 	{
 		
 	}
}
?>