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
 * @version $Id: detail.php 443 2009-12-26 13:49:49Z cht117 $
 */
uses("helptype","help");
$helptype = new Helptypes();
$help = new Helps();
$conditions = array();
$helptype_result = $helptype->findAll("id,title",null, "parent_id=0","display_order ASC,id DESC");
if (!empty($helptype_result)) {
	foreach ($helptype_result as $key=>$val) {
		$helptype_result[$val['id']]['id'] = $val['id'];
		$helptype_result[$val['id']]['name'] = $val['title'];
		$sub_result = $pdb->GetArray("SELECT id,title FROM {$tb_prefix}helptypes WHERE parent_id='".$val['id']."'");
		if (!empty($sub_result)) {
			foreach ($sub_result as $key1=>$val1) {
				$helptype_result[$val['id']]['sub'][$val1['id']]['id'] = $val1['id'];
				$helptype_result[$val['id']]['sub'][$val1['id']]['name'] = $val1['title'];
			}
		}
	}
	setvar("Helptypes", $helptype_result);
}
?>