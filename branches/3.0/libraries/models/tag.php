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
class Tags extends PbModel {
	var $name = "Tag";
 	var $tag;
 	var $exist_id = array();
 	var $inserted_id = array();
 	var $id;
 	

 	function Tags()
 	{
		parent::__construct();
 	}
 	
	function &getInstance() {
		static $instance = array();
		if (!$instance) {
			$instance[0] =& new tags();
		}
		return $instance[0];
	} 	

	function checkTagExists($title)
	{
		$sql = "SELECT id FROM {$this->table_prefix}tags WHERE title='{$title}";
		$result = $this->dbstuff->GetRow($sql);
		if ($result) {
			return true;
		}else{
			return false;
		}
	}

	function setTagId($tags)
	{
		$tmp_exist_tag = array();
		if (empty($tags) || !$tags) {
			return;
		}
		$words = str_replace(array("，"), ",", trim($tags));
		if (strstr($words, ",")) {
			$words = explode(",", $words);
		}else{
			$words = explode(" ", $words);
		}
		$tmp_str = "('".implode("','", $words)."')";
		$result = $this->dbstuff->GetArray("SELECT id,name FROM {$this->table_prefix}tags WHERE name IN ".$tmp_str);
		if (!empty($result)) {
			foreach ($result as $key=>$val){
				$this->exist_id[] = $val['id'];
				$tmp_exist_tag[] = $val['name'];
			}
		}
		$not_exist_tag = array_diff($words, $tmp_exist_tag);
		if (!empty($not_exist_tag)) {
			$tmp_str = array();
			foreach ($not_exist_tag as $val2) {
				if(isset($_SESSION['member_id']))
				$tmp_str[] = "('".$_SESSION['member_id']."','".$val2."',1,".$this->timestamp.",".$this->timestamp.")";
			}
			if(!empty($tmp_str)) $this->dbstuff->Execute("INSERT INTO {$this->table_prefix}tags (member_id,name,numbers,created,modified) VALUES ".implode(",", $tmp_str));
			$result = $this->dbstuff->GetArray("SELECT id,name FROM {$this->table_prefix}tags WHERE name IN ('".implode("','", $not_exist_tag)."')");
			foreach ($result as $val3) {
				$this->inserted_id[] = $val3['id'];
			}
		}
		return $this->getTagId();
	}

	function getTagId()
	{
		$ids = array_merge($this->exist_id, $this->inserted_id);
		$ids = implode(",", $ids);
		if (empty($ids) || !$ids) {
			return '';
		}
		return $ids;
	}
	
	function getTagsByIds($tag_ids, $extra = false)
	{
		$return = array();
		if(empty($tag_ids) || !$tag_ids) return;
		$sql = "SELECT id,name FROM {$this->table_prefix}tags WHERE id IN (".$tag_ids.")";
		$result = $this->dbstuff->GetArray($sql);
		if (!empty($result)) {
			foreach ($result as $val){
				$return[$val['id']] = $val['name'];
			}
			if($extra) $this->tag = implode(" ", $return);
		}
		return $return;
	}
}