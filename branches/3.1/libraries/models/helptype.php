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
class Helptypes extends PbModel {
 	
 	var $name = "Helptype";
 	var $data;

 	function Helptypes()
 	{
 		parent::__construct();
 	}
 	
 	function getTypeOptions($selected = '', $level = 2)
 	{
 		$opt = null;
 		$helptypes = $this->findAll("*", null, null, "level ASC");
 		if (!empty($helptypes)) {
 			foreach ($helptypes as $ret) {
 				$this->data[$ret['id']] = $ret['title'];
 			}
 			for($i=1; $i<=$level; $i++){
 				$opt.='<optgroup label="'.L('type_level'.$i, 'tpl').'">';
 				foreach ($helptypes as $key=>$val){
 					if($val['level']==$i){
 						$opt.='<option value="'.$val['id'].'"';
						if($selected && $selected==$val['id']) $opt.=' selected="selected"';
						$opt.='">'.$val['title'].'</option>';
 					}
 				}
 				$opt.='</optgroup>';
 			}
 			return $opt;
 		}
 	}
}
?>