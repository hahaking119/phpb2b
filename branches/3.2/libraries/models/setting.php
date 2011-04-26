<?php
/**
 * NOTE   :  PHP versions 4 and 5
 *
 * PHPB2B :  An Opensource Business To Business E-Commerce Script (http://www.phpb2b.com/)
 * Copyright 2007-2009, Ualink E-Commerce Co,. Ltd.
 *
 * Licensed under The GPL License (http://www.opensource.org/licenses/gpl-license.php)
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * @copyright Copyright 2007-2009, Ualink E-Commerce Co,. Ltd. (http://phpb2b.com)
 * @since PHPB2B v 1.0.0
 * @link http://phpb2b.com
 * @package phpb2b
 * @version $Id$
 */
class Settings extends PbModel {
 	var $name = "Setting";

 	function Settings()
 	{
		$class_name = $this->name;
		$this->Setting = & new $class_name;
		parent::__construct();

 	}

	function getValues($typeid = null)
	{
		if (!is_null($typeid)) {
			$sql = "SELECT id,variable,valued FROM {$this->table_prefix}settings WHERE type_id='{$typeid}' ";
		}else{
			$sql = "SELECT id,variable,valued FROM {$this->table_prefix}settings";
		}
		$r_res = $this->dbstuff->GetArray($sql);
		$data = array();
		if (!empty($r_res)) {
    		foreach ($r_res as $key=>$value) {
    			$data[strtoupper($value['variable'])] = $value['valued'];
    		}
		}
		return $data;
	}
	
	function replace($datas, $typeid = 0)
	{
		$updated = false;
		$data = null;
		$values = array();
		foreach ($datas as $key=>$val) {
			$values[] = "('".$key."','".$val."','".$typeid."')";
		}
		$data = implode(",", $values);
		$sql = "REPLACE INTO {$this->table_prefix}settings (variable,valued,type_id) values ".$data;
		$updated = $this->dbstuff->Execute($sql);
		return $updated;
	}
}