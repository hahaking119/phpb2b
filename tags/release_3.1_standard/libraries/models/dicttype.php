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
class Dicttypes extends PbModel {
 	
 	var $name = "Dicttype";
 	var $data;
 	var $typeOptions;
 	var $hasChildren;

 	function Dicttypes()
 	{
 		parent::__construct();
 	}
 	
 	function disSubOptions($parent_id, $level)
 	{
 		$data = $this->findAll("*", null, "parent_id='".$parent_id."'", "display_order ASC");
 		if (!empty($data)) {
 			$this->hasChildren=true;
 			foreach ($data as $key=>$val) {
 				$this->typeOptions.='<option value="'.$val['id'].'">';
 				$this->typeOptions.=str_repeat('&nbsp;&nbsp;', $level) . $val['name'];
 				$this->typeOptions.='</option>' . "\n";
 				$this->disSubOptions($val['id'], $level+1);
 			}
 		}else{
 			$this->hasChildren=false;
 		}
 	}
 	
 	function getTypeOptions()
 	{
 		$this->typeOptions = '';
 		$this->disSubOptions(0, 0);
 		return $this->typeOptions;
 	}
 	
 	function getAllTypes()
 	{
 		$data = array();
 		$data = $this->findAll("*", null, "parent_id=0", "display_order ASC");
 		if (!empty($data)) {
 			for($i=0; $i<count($data); $i++) {
 				$sub_data = $this->dbstuff->GetArray("SELECT * FROM {$this->table_prefix}dicttypes WHERE parent_id='".$data[$i]['id']."'");
 				if ($sub_data) {
 					$data[$i]['sub'] = $sub_data;
 				}
 			}
 		}
 		return $data;
 	}
}
?>