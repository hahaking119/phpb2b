<?php
 class Keywordships extends PbModel {
 	var $name = "Keywordship";

 	function Keywordships()
 	{
 		$class_name = $this->name;
		$this->Keywordship = & new $class_name;
 	}
}
?>