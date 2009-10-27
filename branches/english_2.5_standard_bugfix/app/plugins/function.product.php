<?php
/**
 * Note : The Software shall be used for Good, not Evil.
 * PHPB2B - As an open source b2b program.
 *
 * Permission is hereby granted to use this version of the library under the
 * following license:
 *
 * --
 * Copyright (c) 2006-2009 Ualink (http://www.phpb2b.com/)
 *
 * All rights granted under this License are granted for the term of copyright on 
 * the Program, and are irrevocable provided the stated conditions are met. This 
 * License explicitly affirms your unlimited permission to run the unmodified Program. 
 * The output from running a covered work is covered by this License only if the 
 * output, given its content, constitutes a covered work.
 * This License acknowledges your rights of fair use or other equivalent, as provided
 * by copyright law.
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * --
 *
 * @package phpb2b
 * @copyright 2009 Ualink <phpb2b@hotmail.com> (http://www.phpb2b.com/)
 * @license http://www.opensource.org/licenses/gpl-license.php GPL License
 * @created Mon Jun 22 16:42:17 CST 2009
 * @link http://sourceforge.net/projects/php-b2b/
 * @version $Id$
 */
function smarty_function_product($params){
	global $g_db;
	global $smarty, $theme_name, $tb_prefix;
	$conditions = array();
	$limit = null;
	$tpl_file = (isset($params['templet']))?"block.".$params['templet'].".html":"block.default.html";
	extract($params);
	if (class_exists("Products")) {
		$product = new Products();
	}else{
		uses("product");
		$product = new Products();
	}
	$conditions[] = "Product.status=1";
	$fields = "Product.id as LinkId,Product.name as LinkTitle,Product.picture as ItemPicture,Product.picture_remote as ItemRemotePicture,Product.html_file_id as HtmlFileName,Product.created as CreateDate";
	if(isset($params['id'])){
		$result = $product->read($fields, intval($params['id']));
	}else{
		if (isset($params['company_id'])) {
			$conditions[] = "Product.company_id=".$params['company_id'];
		}
		if (isset($params['member_id'])) {
			$conditions[] = "Product.member_id=".$params['member_id'];
		}
		if (isset($params['type'])) {
		    if ($params['type']=="commend" || $params['type']=="hot") {
		    	$conditions[] = "Product.ifcommend='1'";
		    }
		}
		if (isset($params['sort'])) {
			$conditions[] = "Product.sort_id='".$params['sort']."'";
		}
		if (isset($params['type_id'])) {
			$conditions[] = "Product.producttype_id=".$params['type_id'];
		}
		if (isset($params['companytype_id'])) {
		    $joins = " left join ".$tb_prefix."companies on Company.id=Product.company_id";
			$conditions[] = "Company.type_id='".$params['companytype_id']."'";
		}
		if (isset($params['orderby'])) {
			$orderby = " order by Product.".trim($params['orderby']);
		}else{
		    $orderby = " order by Product.id desc";
		}
		$product->setLimit($params['row'], $params['col'], $params['max']);
		$tmp_cond = implode(" and ", $conditions);
		$sql = "select ".$fields." from ".$product->getTable(true).$joins." where ".$tmp_cond.$orderby.$product->getLimit();
		$result = $g_db->GetArray($sql);
	}
	for($i=0; $i<count($result); $i++) {
		if(PRETEND_HTML_LEVEL==0){
		    $url = URL."product/content.php?id=".$result[$i]['LinkId'];
		}else{
		    $dt = getdate($result[$i]['CreateDate']);
	        $url = URL."product/".$dt['year']."/".$dt['mon']."/".$dt['mday']."/".urlencode($result[$i]['LinkTitle'])."/";
		}
		$op = $smarty->fetch($theme_name."/".$tpl_file, null, null, false);
	    $op = str_replace(array("[link:title]", "[field:title]", "[img:thumb]", "[img:src]", "[field:typename]"), array($url, $result[$i]['LinkTitle'], URL."attachment/".$result[$i]['ItemPicture'].".small.jpg", URL."attachment/".$result[$i]['ItemPicture'], ""), $op);
	    //$output.=$product->checkTerminal($i);
	    $output.=$op;
	}
	echo $output;
}
?>