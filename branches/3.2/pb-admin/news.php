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
 * @version $Id: news.php 458 2009-12-27 03:05:45Z steven $
 */
require("../libraries/common.inc.php");
uses("news","newstype", "membertype","attachment", "tag");
require(LIB_PATH .'time.class.php');
require(PHPB2B_ROOT.'libraries/page.class.php');
require("session_cp.inc.php");
$tag = new Tags();
$page = new Pages();
$attachment = new Attachment('pic');
$membertype = new Membertypes();
$news = new Newses();
$newstype = new Newstypes();
$conditions = array();
$fields = null;
$tpl_file = "news";
if (isset($_GET['do'])) {
	$do = trim($_GET['do']);
	if (!empty($_GET['id'])) {
		$id = intval($_GET['id']);
	}
	if ($do == "search") {
		if (isset($_GET['news']['keywords'])) $conditions[]= "News.keywords like '%".trim($_GET['news']['keywords'])."%'";
		if (isset($_GET['news']['source'])) $conditions[]= "News.source like '%".trim($_GET['news']['source'])."%'";
		if (isset($_GET['news']['q'])) $conditions[]= "News.title like '%".trim($_GET['q'])."%'";
		if (!empty($_GET['typeid'])) {
			$conditions[]= "News.type_id=".$_GET['typeid'];
		}
		if (isset($_GET['topicid'])) {
			setvar("Items", $pdb->GetArray("SELECT n.* FROM {$tb_prefix}topicnews tn RIGHT JOIN {$tb_prefix}newses n ON tn.news_id=n.id WHERE tn.topic_id=".intval($_GET['topicid'])));
			setvar("Newstypes", $newstype->getCacheTypes());
			template($tpl_file);
			exit;
		}
	}
	if ($do == "del" && !empty($id)) {
		$sql = "SELECT picture FROM {$tb_prefix}newses WHERE id=".$id;
		$attach_filename = $pdb->GetOne($sql);
		$news->del($_GET['id']);
		$attachment->deleteBySource($attach_filename);
	}
	if ($do == "edit") {
		$news_info = null;
		require(CACHE_PATH. "cache_area.php");
		require(CACHE_PATH. "cache_industry.php");
		setvar("CacheAreas", $_PB_CACHE['area']);
		setvar("CacheIndustries", $_PB_CACHE['industry']);		
		$result = $membertype->findAll("id,name",null, $conditions, " id desc");
		$user_types = array();
		foreach ($result as $key=>$val) {
			$user_types[$val['id']] = $val['name'];
		}
		setvar("Membertypes", $user_types);
		setvar("NewstypeOptions", $newstype->getTypeOptions());
		if(!empty($id)){
			$item_info = $news->read("*",$id);
			if(($item_info['picture'])) $item_info['image'] = pb_get_attachmenturl($item_info['picture'], "../", 'small');
			$tag->getTagsByIds($item_info['tag_ids'], true);
			$item_info['tag'] = $tag->tag;
			setvar("item",$item_info);
		}
		$tpl_file = "news.edit";
		template($tpl_file);
		exit;
	}	
}
if (isset($_POST['update']) && !empty($_POST['if_focus'])) {
	$pdb->Execute("update ".$news->getTable()." set if_focus=0");
	$pdb->Execute("update ".$news->getTable()." set if_focus=1 where id=".intval($_POST['if_focus']));
}
if (isset($_POST['del']) && is_array($_POST['id'])) {
	foreach ($_POST['id'] as $key=>$val){
	    $attach_filename = $pdb->GetOne("select picture from {$tb_prefix}newses where id=".$val);
	    $attachment->deleteBySource($attach_filename);
	}
	$deleted = $news->del($_POST['id']);
	if (!$deleted) {
		flash();
	}
}
if (isset($_POST['save']) && !empty($_POST['data']['news'])) {
	if (isset($_POST['id'])) {
		$id = intval($_POST['id']);
	}
	$attachment->if_orignal = false;
	$attachment->if_watermark = false;
	$attachment->if_thumb_middle = false;
	$vals = array();
	$vals = $_POST['data']['news'];
	if(!empty($_POST['require_membertype']) && !in_array(0, $_POST['require_membertype'])){
		$reses = implode(",", $_POST['require_membertype']);
		$vals['require_membertype'] = $reses;
	}elseif(!empty($_POST['require_membertype'])){
		$vals['require_membertype'] = 0;
	}
	$vals['tag_ids'] = $tag->setTagId($_POST['data']['tag']);
	if(!empty($id)){
		$vals['modified'] = $time_stamp;
		if (!empty($_FILES['pic']['name'])) {
			$attachment->rename_file = "news-".$pdb->GetOne("SELECT created FROM {$tb_prefix}newses WHERE id={$id}");	
			$attachment->insert_new = false;
			$attachment->upload_process();
			$vals['picture'] = $attachment->file_full_url;
		}
		$result = $news->save($vals, "update", $id);
	}else{
		$vals['created'] = $vals['modified'] = $time_stamp;
		if (!empty($_FILES['pic']['name'])) {
			$attachment->rename_file = "news-".$time_stamp;	
			$attachment->upload_process();
			$vals['picture'] = $attachment->file_full_url;
		}
		$result = $news->save($vals);
	}
	if (!$result) {
		flash();
	}
}
$amount = $news->findCount(null, $conditions);
$page->setPagenav($amount);
setvar("Items",$news->findAll("*", null, $conditions, "id DESC ",$page->firstcount,$page->displaypg));
uaAssign(array("ByPages"=>$page->pagenav, "Newstypes"=>$newstype->getCacheTypes()));
template($tpl_file);
?>