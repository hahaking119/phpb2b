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
 * @version $Id: block.friendlink.php 438 2009-12-26 13:48:41Z steven $
 */
function smarty_block_friendlink($params, $content, &$smarty) {
	global $pdb, $tb_prefix;
	if ($content === null) return;
	$conditions = array();
	$conditions[] = "status='1'";
	if (!class_exists("Friendlinks")) {
		uses("friendlink");
		$friendlink = new Friendlinks();
	}else{
	    $friendlink = new Friendlinks();
	}
	$show_logo = false;
	if (isset($params['type'])) {
		if ($params['type']=='image') {
			$conditions[] = "picture!=''";
		}
	}
	$friendlink->setCondition($conditions);
	$result = $pdb->GetArray("SELECT * FROM {$tb_prefix}friendlinks ".$friendlink->getCondition()." ORDER BY priority ASC");
	$return = null;
	if (!empty($result)) {
		$i_count = count($result);
		for ($i=0; $i<$i_count; $i++){
			$url = $result[$i]['url'];			
			$return.= str_replace(array("[link:title]", "[field:title]", "[field:target]", "[field:style]", "[field:tip]", "[field:logo]"), array($url, $result[$i]['title'], $result[$i]['target'], $result[$i]['style'], $result[$i]['tip'], $result[$i]['image']), $content);
		}
	}
	return $return;
}
?>