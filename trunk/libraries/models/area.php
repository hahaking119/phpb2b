<?php
class Areas extends PbModel {

	
	var $name = "Area";

	function Areas()
	{
		
	}

	function getAllArea($conditions = null)
	{
		$sql = "SELECT Area.id AS AreaId,Area.name AS AreaName,Area.code_id AS AreaCodeId ";
		$sql.= "FROM ".$this->getTable(true)." ";
		$sql.= "WHERE 1 ";
		$sql.= $conditions;
		$sql.= " ORDER BY Area.id ";
		$tmp_arr = $GLOBALS['g_db']->GetAll($sql);
		return $tmp_arr;
	}
	
	function getSubAreaById($area_id)
	{
		$code_id = $this->find($area_id, "code_id", "id");
		$sql = "select * from ".$this->getTable(true)." where LEFT(code_id,3)=".substr($code_id,0,3);
		$return = $GLOBALS['g_db']->GetAll($sql);
		return $return;
	}
}
?>