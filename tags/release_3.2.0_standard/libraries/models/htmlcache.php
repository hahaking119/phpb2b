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
class Htmlcaches extends PbModel {
	var $name = "Htmlcache";
	
	function Htmlcaches()
	{
		parent::__construct();
	}
	
	function &getInstance() {
		static $instance = array();
		if (!$instance) {
			$instance[0] =& new Htmlcaches();
		}
		return $instance[0];
	}

	function updateCacheTime($mix_page_id){
		global $data;
		$data['Htmlcache']['h_n'] = $mix_page_id;
		if(is_string($mix_page_id)){
			$id = $this->field("id", "h_n='".trim($mix_page_id)."'");
		}elseif(is_int($mix_page_id)){
			$id = trim($mix_page_id);
		}
		$data['Htmlcache']['h_l'] = $this->timestamp;
		if($id){
			$result = $this->save($data['Htmlcache'], "update", $id);
		}else{
			$result = $this->save($data['Htmlcache']);
		}
		if($result){
			return true;
		}else{
			return false;
		}
	}

	function needRecache($mix_page_id){
		if(is_string($mix_page_id)){
			$id = $this->field("id", "h_n='".trim($mix_page_id)."'");
		}elseif(is_int($mix_page_id)){
			$id = trim($mix_page_id);
		}
		if(!empty($id)) {
			$tmp_result = $this->read("h_l as LastCacheTime, h_r as CacheCycle", $id);
			$time1 = intval($tmp_result['LastCacheTime']+$tmp_result['CacheCycle']);
			if($time1<=0 || $this->timestamp>$time1){
				return true;
			}else{
				return false;
			}
		}else{
			return true;
		}
	}
	
	function updateModified($conditions = array())
	{
		$condition = $result = null;
		$sql = "UPDATE {$this->table_prefix}trades SET modified={$this->timestamp}";
		if (!empty($conditions) && is_array($conditions)) {
			$tmp_conditions = array();
			$condition.= " WHERE ";
			foreach ($conditions as $key=>$val) {
				$tmp_conditions[] = "`{$key}`"."='".$val."'";
			}
			$condition.= implode(" AND ", $tmp_conditions);
		}
		$sql.= $condition;
		$result = $this->dbstuff->Execute($sql);
		unset($tmp_conditions, $sql, $condition, $conditions);
		return $result;
	}
}
?>