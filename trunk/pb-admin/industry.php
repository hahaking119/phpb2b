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
 * @version $Id: industry.php 481 2009-12-28 01:05:06Z steven $
 */
require("../libraries/common.inc.php");
require(LIB_PATH. 'wordsconvert.class.php');
require(LIB_PATH. 'page.class.php');
require(CACHE_PATH. "cache_industrytype.php");
require(CACHE_PATH. "cache_industry.php");
require("session_cp.inc.php");
require(LIB_PATH. "json_config.php");
require(LIB_PATH. "cache.class.php");
require(LIB_PATH. "typemodel.inc.php");
uses("industry");
$cache = new Caches();
$industry = new Industries();
$condition = null;
$conditions = array();
$tpl_file = "industry";
$page = new Pages();
setvar("Types", $_PB_CACHE['industrytype']);
setvar("CacheItems", $cache_items = $_PB_CACHE['industry']);
setvar("AskAction", get_cache_type("common_option"));
if (isset($_POST['del'])) {
	if (!empty($_POST['id'])) {
		$industry->del($_POST['id']);
	}
}
if (isset($_POST['do'])) {
	$do = trim($_POST['do']);
	if ($do == "clear") {
		foreach ($_POST['data']['level'] as $key=>$val){
			$result = $pdb->Execute("DELETE FROM {$tb_prefix}industries WHERE level='".$val."'");
		}
		if(!$result){
			flash();
		}
	}
}
if (isset($_POST['update_batch'])) {
	if (!empty($_POST['data']['iname'])) {
		for($i=0; $i<count($_POST['data']['iname']); $i++) {
			$pdb->Execute("UPDATE {$tb_prefix}industries SET name = '".$_POST['data']['iname'][$i]."' WHERE id='".$_POST['iid'][$i]."'");
		}
		flash("success");
	}
}
if (isset($_POST['save'])) {
	if (isset($_POST['data']['industry']['parent_id'])) {
		$parent_id = $_POST['data']['industry']['parent_id'];
		if ($parent_id == 0) {
			$top_parentid = $_POST['data']['industry']['top_parentid'] = 0;
			$level = $_POST['data']['industry']['level'] = 1;
		}else{
			if (array_key_exists($parent_id, $cache_items[1])) {
				$level = $_POST['data']['industry']['level'] = 2;
				$top_parentid = $_POST['data']['industry']['top_parentid'] = $parent_id;
			}elseif (array_key_exists($parent_id, $cache_items[2])){
				$level = $_POST['data']['industry']['level'] = 3;
				$top_parentid = $_POST['data']['industry']['top_parentid'] = $pdb->GetOne("SELECT parent_id FROM {$tb_prefix}industries WHERE id=".$parent_id);
			}
		}
	}
	if (isset($_POST['id'])) {
		$id = intval($_POST['id']);
		$result = $industry->save($_POST['data']['industry'], "update", $id);
	}elseif (!empty($_POST['data']['names'])){
		$names = explode("\r\n", $_POST['data']['names']);
		$tmp_name = array();
		if (!empty($names)) {
			foreach ($names as $val) {
				$name = $val;
				if(!empty($name)) $tmp_name[] = "('".$name."','".$_POST['data']['industry']['url']."','".$parent_id."','".$top_parentid."','".$level."','".$_POST['data']['industry']['display_order']."','".$_POST['data']['industry']['industrytype_id']."')";
			}
			$values = implode(",", $tmp_name);
			$sql = "INSERT INTO {$tb_prefix}industries (name,url,parent_id,top_parentid,level,display_order,industrytype_id) VALUES ".$values;
			$result = $pdb->Execute($sql);
		}
	}
	if ($result) {
		$cache->writeCache("industry", "industry");
	}
}
if (isset($_GET['do'])) {
	$do = trim($_GET['do']);
	if (!empty($_GET['id'])) {
		$id = intval($_GET['id']);
	}
	if ($do == "level") {
		if(!empty($id)){
			if ($_GET['action']=="up") {
				$pdb->Execute("UPDATE {$tb_prefix}industries SET display_order=display_order+1 WHERE id=".$id);
			}elseif ($_GET['action']=="down"){
				$pdb->Execute("UPDATE {$tb_prefix}industries SET display_order=display_order-1 WHERE id=".$id);
			}
		}
	}
	if ($do == "refresh") {
		$cache->writeCache("industry", "industry");
		$data = array();
		$op = "<?php\n";
		$op.="return ";
		foreach ($_PB_CACHE['industry'][1] as $key1=>$val1) {
			$data[$key1]['id'] = $key1;
			$data[$key1]['name'] = $val1;
			$tmp_result1 = $pdb->GetArray("SELECT id,name,level FROM {$tb_prefix}industries WHERE level=2 AND parent_id=".$key1." ORDER BY display_order ASC");
			if (!empty($tmp_result1)) {
				foreach ($tmp_result1 as $key2=>$val2) {
					$data[$key1]['sub'][$key2]['id'] = $val2['id'];
					$data[$key1]['sub'][$key2]['name'] = $val2['name'];
					$tmp_result2 = $pdb->GetArray("SELECT id,name,level FROM {$tb_prefix}industries WHERE level=3 AND parent_id=".$val2['id']." ORDER BY display_order ASC");
					if (!empty($tmp_result2)) {
						foreach ($tmp_result2 as $key3=>$val3) {
							$data[$key1]['sub'][$key2]['sub'][$key3]['id'] = $val3['id'];
							$data[$key1]['sub'][$key2]['sub'][$key3]['name'] = $val3['name'];
						}
					}
				}
			}
		}
		$op.=$cache->evalArray($data);
		$op.="\n";
		$op.="?>";
		$fp = file_put_contents(CACHE_PATH. "industry.php", $op);
		flash("success");
	}
	if ($do == "search") {
		if (!empty($_GET['name'])) {
			$conditions[] = "name LIKE '%".$_GET['name']."%'";
		}
		if (isset($_GET['parentid'])) {
			$conditions[] = "parent_id=".intval($_GET['parentid']);
		}
		if (isset($_GET['level'])) {
			$conditions[] = "level=".intval($_GET['level']);
		}
		if (isset($_GET['typeid'])) {
			$conditions[] = "industrytype_id=".intval($_GET['typeid']);
		}
	}
	if ($do == "edit") {
		if (!empty($id)) {
			$res = $pdb->GetRow("SELECT * FROM {$tb_prefix}industries WHERE id=".$id);
			setvar("item", $res);
		}
		$tpl_file = "industry.edit";
		template($tpl_file);
		exit;
	}
	if ($do == "clear") {
		$tpl_file = "industry.clear";
		template($tpl_file);
		exit;
	}
}
$amount = $industry->findCount(null, $conditions);
$page->setPagenav($amount);
$result = $industry->findAll("id,name,name as title,highlight,parent_id,industrytype_id,top_parentid,level,display_order", null, $conditions, "level ASC,display_order DESC,id DESC", $page->firstcount, $page->displaypg);
if (!empty($result)) {
	for($i=0; $i<count($result); $i++){
		$tmp_name = array();
		if($result[$i]['level']>1){
			if($result[$i]['level']>2){
				$tmp_name[] = $result[$i]['name'];
				if($_PB_CACHE['industry'][2][$result[$i]['parent_id']]) $tmp_name[] = "<a href='industry.php?do=search&parentid=".$result[$i]['parent_id']."'>".$_PB_CACHE['industry'][2][$result[$i]['parent_id']]."</a>";
				if($_PB_CACHE['industry'][1][$result[$i]['top_parentid']]) $tmp_name[] = "<a href='industry.php?do=search&parentid=".$result[$i]['top_parentid']."'>".$_PB_CACHE['industry'][1][$result[$i]['top_parentid']]."</a>";
			}else{
				$tmp_name[] = "<a href='industry.php?do=search&parentid=".$result[$i]['id']."'>".$result[$i]['name']."</a>";
				if($_PB_CACHE['industry'][1][$result[$i]['parent_id']]) $tmp_name[] = "<a href='industry.php?do=search&parentid=".$result[$i]['parent_id']."'>".$_PB_CACHE['industry'][1][$result[$i]['parent_id']]."</a>";
			}
		}else{
			$tmp_name[] = "<a href='industry.php?do=search&parentid=".$result[$i]['id']."'>".$result[$i]['name']."</a>";
		}
		$result[$i]['title'] = implode("«", $tmp_name);
	}
	setvar("Items", $result);
	setvar("ByPages", $page->pagenav);
}
template($tpl_file);
?>