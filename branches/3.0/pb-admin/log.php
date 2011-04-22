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
 * @version $Id: log.php 427 2009-12-26 13:45:47Z steven $
 */
require("../libraries/common.inc.php");
uses("log");
require(PHPB2B_ROOT.'./libraries/page.class.php');
require("session_cp.inc.php");
$log = new Logs();
$page = new Pages();
$conditions = array();
if (isset($_GET['do'])) {
	$do = trim($_GET['do']);
	if ($do == "clear") {
		$result = $pdb->Execute("truncate {$tb_prefix}logs");
	}
	if ($do == "del" && !empty($_GET['id'])) {
		$log->del($_GET['id']);
	}
	if($do == 'search'){
		if(!empty($_GET['q'])){
			$conditions[] = "description like '%".$_GET['q']."%'";
		}
	}
}
$amount = $log->findCount(null, $conditions, "id");
$page->setPagenav($amount);
$result = $log->findAll("id,handle_type,source_module,description,created,created AS pubdate", null, $conditions, "id DESC ",$page->firstcount,$page->displaypg);
if(!empty($result)){
	for($i=0; $i<count($result); $i++){
		$result[$i]['label'] = "images/e_".$result[$i]['handle_type'].".gif";
		$result[$i]['pubdate'] = date("Y-m-d H:i:s", $result[$i]['created']);
	}
	setvar("Items", $result);
}
setvar("ByPages",$page->pagenav);
template("log");
?>