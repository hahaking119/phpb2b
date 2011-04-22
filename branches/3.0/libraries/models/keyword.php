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
class Keywords extends PbModel {
	var $name = "Keyword";
 	var $type_condition;
 	var $exist_keyword_id = array();
 	var $inserted_keyword_id = array();
 	var $keyword_id;

 	function Keywords()
 	{
		parent::__construct();
 	}
 	
	function &getInstance() {
		static $instance = array();
		if (!$instance) {
			$instance[0] =& new Keywords();
		}
		return $instance[0];
	} 	

	function checkKeywordExists($title)
	{
		$sql = "SELECT id FROM {$this->table_prefix}keywords WHERE title='{$title}";
		$result = $this->dbstuff->GetRow($sql);
		if ($result) {
			return true;
		}else{
			return false;
		}
	}

	function setKeywordId($keys, $prim_id, $type_id)
	{
	    if(!empty($keys)){
	        $words = str_replace(array("，", " ", "　"), ",", $keys);
	        $words = explode(",", $words);
	        foreach ($words as $key=>$val){
	            $val = trim($val);
	            $kid = $this->dbstuff->GetOne("select id from {$this->table_prefix}keywords where title='".$val."' and type='$type_id'");
	            if ($kid) {
	                $pid = $this->dbstuff->GetOne("select primary_id from {$this->table_prefix}keywords where id=".$kid);
	                if ($pid) {
	                    $exist_ids = explode(",", $pid);
	                    if(!in_array($prim_id, $exist_ids)) {
	                        $exist_ids[] = $prim_id;
	                        $exist_ids = implode(",", $exist_ids);
	                        $this->dbstuff->Execute("update {$this->table_prefix}keywords set primary_id='".$exist_ids."' where id=".$kid);
	                        $this->exist_keyword_id[] = $kid;
	                    }
	                }else{
	                    $this->dbstuff->Execute("update {$this->table_prefix}keywords set primary_id='".$prim_id."' where id=".$kid);
	                    $this->exist_keyword_id[] = $kid;
	                }
	            }else{
	                $this->dbstuff->Execute("insert into {$this->table_prefix}keywords (title,primary_id,member_id,type,created) values ('$val','$prim_id','".$_SESSION['MemberID']."','$type_id','".date("Y-m-d H:i:s")."')");
	                $this->inserted_keyword_id[] = $this->dbstuff->Insert_ID();
	            }
	        }
	    }
		unset($exist_ids, $kid, $pid, $words);
	}

	function getKeywordId()
	{
		$ids = array_merge($this->exist_keyword_id, $this->inserted_keyword_id);
		$ids = implode(",", $ids);
		return $ids;
	}
	
	function checkSegmentwordExists($word){
		$sql = "SELECT id FROM {$this->table_prefix}segmentwords WHERE name='{$word}";
		$result = $this->dbstuff->GetRow($sql);
		if ($result) {
			return true;
		}else{
			return false;
		}
	}
	
	function getKeywordsByIds($keywords)
	{
		$sql = "SELECT title FROM {$this->table_prefix}keywords WHERE id IN (".$keywords.")";
		$result = $this->dbstuff->GetArray($sql);
		return $result;
	}
}