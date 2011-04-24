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
 * @version $Id: userpage.php 427 2009-12-26 13:45:47Z steven $
 */
require("../libraries/common.inc.php");
require("session_cp.inc.php");
require(LIB_PATH. "cache.class.php");
require(LIB_PATH. "file.class.php");
uses("userpage");
$cache = new Caches();
$userpage = new Userpages();
$conditions = null;
$tpl_file = "userpage";
$file = new Files();
if (isset($_POST['del']) && is_array($_POST['id'])) {
	$deleted = $userpage->del($_POST['id']);
	if (!$deleted) {
		flash();
	}
	$cache->writeCache("userpage", "userpage");
}
if (isset($_POST['save'])) {
	$vals = array();
	$vals = $_POST['data']['userpage'];
	if (!empty($_POST['id'])) {
		$vals['modified'] = $time_stamp;
		$result = $userpage->save($vals, "update", $_POST['id']);
	}else{
		$vals['created'] = $vals['modified'] = $time_stamp;
		$result = $userpage->save($vals);
	}
	if (!$result) {
		flash();
	}
	$cache->writeCache("userpage", "userpage");
}
if (isset($_GET['do'])) {
	$do = trim($_GET['do']);
	if (!empty($_GET['id'])) {
		$id = intval($_GET['id']);
	}
	if ($do=="del" && !empty($id)) {
		$deleted = $userpage->del($id);
		$cache->writeCache("userpage", "userpage");
	}
	if ($do == "edit") {
		if(!empty($id)){
			$res= $userpage->read("*",$id);
			setvar("item",$res);
		}
		setvar("tplext", $smarty->tpl_ext);
		$tmp_pagetemplets = $file->getFiles(PHPB2B_ROOT."templates".DS.$theme_name);
		if (!empty($tmp_pagetemplets)) {
			$page_templets = "<optgroup label='".L("other_templet", "tpl")."'>";
			foreach ($tmp_pagetemplets as $p_val) {
				if (strstr($p_val['name'], "page.")) {
					$page_templets.= "<option value=".$p_val['name'].">".$p_val['name']."</option>";
				}
			}
			$page_templets.="</optgroup>";
			setvar("other_templets", $page_templets);
		}
		$tpl_file = "userpage.edit";
		template($tpl_file);
		exit;
	}
}
setvar("Items",$userpage->findAll("id,title,name,url,digest,display_order", null, $conditions, "display_order ASC,id ASC"));
template($tpl_file);
?>