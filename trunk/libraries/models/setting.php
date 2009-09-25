<?php
 class Settings extends PbModel {


 	var $name = "Setting";

 	function Settings()
 	{
		$class_name = $this->name;
		$this->Setting = & new $class_name;

 	}

	function getValues()
	{
		$sql = "SELECT id AS ID,variable AS uaVariable,valued AS uaValue FROM ".$this->getTable(true)." ";
		$r_res = $GLOBALS['g_db']->GetAll($sql);
		$r_vals = array();
		if (!empty($r_res)) {
    		foreach ($r_res as $key=>$value) {
    			$r_vals[strtoupper($value['uaVariable'])] = $value['uaValue'];
    		}
		}

		return $r_vals;
	}

	function test(){
		echo $this->Setting->test();
	}
}