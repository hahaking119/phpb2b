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

	function getCacheIndustry()
	{
		$data = require(CACHE_PATH. "industry.php");
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
		$result = $this->dbstuff->GetArray("SELECT id,name,url FROM {$this->table_prefix}industries i WHERE parent_id='".$id."'");
		if (!$result || empty($result)) {
			if ($extra) {
				$row = $this->dbstuff->GetRow("SELECT id,level,parent_id FROM {$this->table_prefix}industries i WHERE id='".$id."'");
				if (!$row || empty($row)) {
					$return = $this->dbstuff->GetArray("SELECT id,name,url FROM {$this->table_prefix}industries WHERE parent_id='0'");
					return $return;
				}else{
					$return = $this->dbstuff->GetArray("SELECT id,name,url FROM {$this->table_prefix}industries WHERE parent_id='".$row['parent_id']."'");
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
}
?>