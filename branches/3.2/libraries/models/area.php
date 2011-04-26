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
class Areas extends PbModel {
	var $name = "Area";

	function Areas()
	{
		parent::__construct();
	}
	
 	function rewrite($id, $name = '')
 	{
 		global $rewrite_able, $rewrite_compatible;
 		if ($rewrite_able) {
 			if ($rewrite_compatible && !empty($name)) {
 				return "area/".rawurlencode($name)."/";
 			}else{
 				return "area/".$id."/";
 			}
 		}else{
 			return "special/area.php?id=".$id;
 		}
 	}
	
 	function setInfo($id)
 	{
 		$result = $this->dbstuff->GetRow("SELECT * FROM {$this->table_prefix}areas WHERE id=".$id);
 		if (!($result) || empty($result)) {
 			return null;
 		}else {
 			$this->info = $result;
 			return $result;
 		}
 	}
 	
 	function getInfo()
 	{
 		return $this->info;
 	}	
	
	function &getInstance() {
		static $instance = array();
		if (!$instance) {
			$instance[0] =& new Areas();
		}
		return $instance[0];
	}
	
	function getSubArea($id, $extra = false)
	{
		$return = array();
		$result = $this->dbstuff->GetArray("SELECT id,name,url FROM {$this->table_prefix}areas WHERE parent_id='".$id."' ORDER BY display_order ASC");
		if (!$result || empty($result)) {
			if ($extra) {
				$row = $this->dbstuff->GetRow("SELECT id,level,parent_id FROM {$this->table_prefix}areas WHERE id=".$id);
				if (!$row || empty($row)) {
					return null;
				}else{
					$return = $this->dbstuff->GetArray("SELECT id,name,url FROM {$this->table_prefix}areas WHERE parent_id='".$row['parent_id']."' ORDER BY display_order ASC");
					return $return;
				}
			}else{
				return null;
			}
		}else{
			$return = $this->dbstuff->GetArray("SELECT id,name,url FROM {$this->table_prefix}areas WHERE parent_id=0 ORDER BY display_order ASC");
			return $return;
		}
		return $result;
	}	
	
	function getCacheArea()
	{
		include(CACHE_PATH. "cache_area.php");
		return $_PB_CACHE['area'];
	}
	
	function getLevelAreas()
	{
		$return = array();
		$result = $this->dbstuff->GetArray("SELECT id,name,url FROM {$this->table_prefix}areas WHERE parent_id=0");
		if (!empty($result)) {
			foreach ($result as $val) {
				$return[$val['id']]['id'] = $val['id'];
				$return[$val['id']]['name'] = $val['name'];
				$result_level = $this->dbstuff->GetArray("SELECT id,name,url FROM {$this->table_prefix}areas WHERE parent_id=".$val['id']);
				if (!empty($result_level)) {
					foreach ($result_level as $level_val) {
						$return[$val['id']]['sub'][$level_val['id']]['id'] = $level_val['id'];
						$return[$val['id']]['sub'][$level_val['id']]['name'] = $level_val['name'];
					}
				}
			}
			return $return;
		}else{
			return false;
		}
	}
}
?>