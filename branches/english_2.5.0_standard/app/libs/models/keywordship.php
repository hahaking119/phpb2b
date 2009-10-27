<?php
 class Keywordships extends UaModel {
 	var $name = "Keywordship";

 	function Keywordships()
 	{
 		$class_name = $this->name;
		$this->Keywordship = & new $class_name;
 	}
}
?>