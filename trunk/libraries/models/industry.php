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
class Industries extends PbModel {
	var $name = "Industry";
	var $info;

 	function Industries()
 	{
		parent::__construct();
 	}
 	
 	function rewrite($id, $name = '')
 	{
 		global $rewrite_able, $rewrite_compatible;
 		if ($rewrite_able) {
 			if ($rewrite_compatible && !empty($name)) {
 				return "industry/".rawurlencode($name)."/";
 			}else{
 				return "industry/".$id."/";
 			}
 		}else{
 			return "special/industry.php?id=".$id;
 		}
 	}
 	
 	function setInfo($id)
 	{
 		$result = $this->dbstuff->GetRow("SELECT * FROM {$this->table_prefix}industries WHERE id=".$id);
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

	function getCacheIndustry($module = 0)
	{
		$data = include(CACHE_PATH. "industry.php");
		return $data;
	}
	
	function getIndustry()
	{
		include(CACHE_PATH. "cache_industry.php");
		return $_PB_CACHE['industry'];
	}
	
	function getSubIndustry($id, $extra = false)
	{
		$return = array();
		$result = $this->dbstuff->GetArray("SELECT id,name,url FROM {$this->table_prefix}industries i WHERE parent_id='".$id."' ORDER BY display_order ASC");
		if (!$result || empty($result)) {
			if ($extra) {
				$row = $this->dbstuff->GetRow("SELECT id,level,parent_id FROM {$this->table_prefix}industries i WHERE id='".$id."'");
				if (!$row || empty($row)) {
					$return = $this->dbstuff->GetArray("SELECT id,name,url FROM {$this->table_prefix}industries WHERE parent_id='0' ORDER BY display_order ASC");
					return $return;
				}else{
					$return = $this->dbstuff->GetArray("SELECT id,name,url FROM {$this->table_prefix}industries WHERE parent_id='".$row['parent_id']."' ORDER BY display_order ASC");
					return $return;
				}
			}else{
				return null;
			}
		}else{
			return $result;
		}
		return $result;
	}
	
	function updateCache()
	{
		global $cache;
	}
	
	function getMinalId()
	{
		$args = func_get_args();
		if (!empty($args)) {
			foreach ($args as $key=>$val) {
				if($val==0) return intval($args[$key-1]);
			}
		}else {
			return false;
		}
	}
}
?>