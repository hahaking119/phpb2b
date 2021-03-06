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
class Templets extends PbModel {
 	var $name = "Templet";

 	function Templets()
 	{
 		parent::__construct();
 	}
 	
	function &getInstance() {
		static $instance = array();
		if (!$instance) {
			$instance[0] =& new Templets();
		}
		return $instance[0];
	}
	
	function getInstalled($membergroup_id = null, $membertype_id = null){
		$installed = array();
		if (!empty($membergroup_id)) {
			$conditions[] = "INSTR(t.require_membergroups,'[".$membergroup_id."]')>0";
			//$sql = "SELECT t.name, t.id, t.directory, t.author, t.title FROM {$this->table_prefix}templets t WHERE INSTR(t.require_membergroups,'[".$membergroup_id."]')>0 OR t.require_membergroups=0 ORDER BY t.id DESC";
		}
		if (!empty($membertype_id)) {
			$conditions[] = "INSTR(t.require_membertype,'[".$membertype_id."]')>0";
		}
		$this->setCondition($conditions);
		$condition = $this->getCondition();
		if (!empty($condition)) {
			$condition.=" OR t.require_membergroups=0";
		}else{
			$condition.=" WHERE 1 OR t.require_membergroups=0";
		}
		$sql = "SELECT t.name, t.id, t.directory, t.author, t.title FROM {$this->table_prefix}templets t {$condition} ORDER BY t.id DESC";
		$result = $this->dbstuff->GetArray($sql);
		if (!empty($result)) {
			$count = count($result);
			for($i=0; $i<$count; $i++){
				if(file_exists(PHPB2B_ROOT .$result[$i]['directory']."screenshot.jpg")){
					$result[$i]['picture'] = URL.$result[$i]['directory']."screenshot.jpg";
				}else{
					$result[$i]['picture'] = '';
				}
				$result[$i]['available'] = 1;
			}
		}
		return $result;
	}	
}
?>