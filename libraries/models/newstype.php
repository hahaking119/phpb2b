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
class Newstypes extends PbModel {

 	var $name = "Newstype";
 	var $data;

 	function Newstypes()
 	{
		parent::__construct();
 	}
 	
 	function getTypeOptions($selected = '', $level = 2)
 	{
		$types = $this->findAll("*", null, null, "level_id ASC");
		$type_opts = array();
		$opt = null;
		if (!empty($types)) {
 			foreach ($types as $ret) {
 				$this->data[$ret['id']] = $ret['name'];
 			}
			for($i=1; $i<=$level; $i++){
				$opt.='<optgroup label="'.L("type_level".$i, "tpl").'">';
				foreach ($types as $key=>$val){
					if($val['level_id']==$i){
						$opt.='<option value="'.$val['id'].'"';
						if($selected && $selected==$val['id']) $opt.=' selected="selected"';
						$opt.='">'.$val['name'].'</option>';
					}
				}
				$opt.='</optgroup>';
			}
		}
		return $opt;
 	}
 	
 	function getCacheTypes()
 	{
 		if (!isset($_PB_CACHE['newstype'])) {
 			require(CACHE_PATH."cache_newstype.php");
 		}
 		return $_PB_CACHE['newstype'];
 	}
}
?>