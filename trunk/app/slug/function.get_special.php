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
 * @version $Id: block.industry.php 438 2009-12-26 13:48:41Z steven $
 */
function smarty_function_get_special($params) {
	global $smarty;
	$conditions = array();
	$orderby = $table_name = null;
	if (isset($params['orderby'])) {
		$orderby = " ORDER BY ".trim($params['orderby'])." ";
	}else{
		$orderby = " ORDER BY display_order ASC,id ASC";
	}
	if (isset($_GET['type']) && in_array($_GET['type'], arraY("area", "industry"))) {
		$table_name = trim($_GET['type']);
	}elseif (isset($params['from'])) {
		$table_name = trim($params['from']);
	}else{
		return;
	}
	switch ($table_name) {
		case "industry":
			if (class_exists("Industries")) {
				$obj = new Industries();
			}else{
				uses("industry");
				$obj = new Industries();
			}
			$table_name = $obj->table_prefix."industries";
			break;
		case "area":
			if (class_exists("Areas")) {
				$obj = new Areas();
			}else{
				uses("area");
				$obj = new Areas();
			}
			$table_name = $obj->table_prefix."areas";
			break;
		default:
			$smarty->trigger_error("Unknow Special Name.");
			return;
			break;
	}
	$fields = "id,name,highlight,url";
	$op = '<ul>';
	switch ($params['depth']) {
		case 3:
			$result1 = $obj->dbstuff->GetArray("SELECT $fields FROM {$table_name} WHERE level=1 AND available=1 {$orderby}");
			foreach ($result1 as $key1=>$val1){
				$result2 = array();
				$url = (!empty($val1['url']))?$val1['url']:$obj->rewrite($val1['id'], $val1['name']);
				$op.='<li class="level-1"><h3><a href="'.$url.'">'.$val1['name'].'</a></h3><ul>';
				$result2 = $obj->dbstuff->GetArray("SELECT $fields FROM {$table_name} WHERE level=2 AND parent_id=".$val1['id']." {$orderby}");
				foreach ($result2 as $key2=>$val2) {
					$result3 = array();
					$url = (!empty($val2['url']))?$val2['url']:$obj->rewrite($val2['id'], $val2['name']);
					$op.='<li class="level-2"><h4>[<a href="'.$url.'">'.$val2['name'].'</a>]</h4>
				<ul class="clearfix">';
					$result3 = $obj->dbstuff->GetArray("SELECT $fields FROM {$table_name} WHERE level=3 AND parent_id=".$val2['id']." {$orderby}");
					foreach ($result3 as $key3=>$val3) {
						$url = (!empty($val3['url']))?$val3['url']:$obj->rewrite($val3['id'], $val3['name']);
						$op.='<li class="level-3" title="'.$val3['name'].'"><a href="'.$url.'">'.$val3['name'].'</a></li>';
					}
					$op.='</ul>';
					$op.='</li>';
				}
				$op.='</ul>';
				$op.='</li>';
			}
			break;
		case 2:
			$result1 = $obj->dbstuff->GetArray("SELECT $fields FROM {$table_name} WHERE level=1 {$orderby}");
			foreach ($result1 as $key1=>$val1){
				$result2 = array();
				$url = (!empty($val1['url']))?$val1['url']:$obj->rewrite($val1['id'], $val1['name']);
				$op.='<li class="level-1"><h3><a href="'.$url.'">'.$val1['name'].'</a></h3><ul>';
				$result2 = $obj->dbstuff->GetArray("SELECT $fields FROM {$table_name} WHERE level=2 AND parent_id=".$val1['id']." {$orderby}");
				foreach ($result2 as $key2=>$val2) {
					$url = (!empty($val2['url']))?$val2['url']:$obj->rewrite($val2['id'], $val2['name']);
					$op.='<li class="level-2"><h4>[<a href="'.$url.'">'.$val2['name'].'</a>]</h4>';
					$op.='</li>';
				}
				$op.='</ul>';
				$op.='</li>';
			}			
			break;
		case 1:
			$result1 = $obj->dbstuff->GetArray("SELECT $fields FROM {$table_name} WHERE level=1 {$orderby}");
			foreach ($result1 as $key1=>$val1){
				$url = (!empty($val1['url']))?$val1['url']:$obj->rewrite($val1['id'], $val1['name']);
				$op.='<li class="level-1"><h3><a href="'.$url.'">'.$val1['name'].'</a></h3>';
				$op.='</li>';
			}	
			break;
		default:
			break;
	}
	$op.= '</ul>';
	echo $op;
}
?>