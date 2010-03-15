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
class Trades extends PbModel {
 	var $name = "Trade";
 	var $info;

 	function Trades()
 	{
		parent::__construct();
 	}
 	
	function &getInstance() {
		static $instance = array();
		if (!$instance) {
			$instance[0] =& new Trades();
		}
		return $instance[0];
	}
 	
 	function checkExist($id, $extra = false)
 	{
 		$id = intval($id);
 		$info = $this->dbstuff->GetRow("SELECT title FROM {$this->table_prefix}trades WHERE id={$id}");
 		if (empty($info) or !$info) {
 			return false;
 		}else{
 			return true;
 		}
 	}
 	
	function getInfoById($pid)
	{
		$sql = "select tf.*,t.id,t.industry_id1,t.industry_id2,t.id,t.title,t.content,t.company_id,t.member_id,t.picture,t.area_id1,t.area_id2,t.status,t.type_id,t.submit_time AS pubdate,expire_time AS expdate,require_membertype,require_point,t.tag_ids,t.formattribute_ids,t.if_urgent from {$this->table_prefix}trades t left join {$this->table_prefix}tradefields tf on  tf.trade_id=t.id WHERE t.id=".$pid;
		$result = $this->dbstuff->GetRow($sql);
		$result['tel'] = $result['prim_telnumber'];
		if (!empty($result['picture'])) {
			$result['image'] = pb_get_attachmenturl($result['picture'], '');
			$result['image_url'] = rawurlencode($result['picture']);
		}
		if (!empty($result['tag_ids'])) {
			uses("tag");
			$tag = new Tags();
			$tag_res = $tag->getTagsByIds($result['tag_ids']);
			if (!empty($tag_res)) {
				$tags = null;
				foreach ($tag_res as $key=>$val){
					$tags.='<a href="offer/list.php?do=search&q='.urlencode($val).'" target="_blank">'.$val.'</a>&nbsp;';	
				}
				$result['tag'] = $tags;
				unset($tags, $tag_res, $tag);
			}
		}
		return $result;
	}

	function checkAccess($trade_info_un){
		$trade_info = unserialize($trade_info_un);
		global $tmp_status;
		global $pb_userinfo;
		if($trade_info['TradeStatus']!=1){
			$tmp_key = intval($trade_info['TradeStatus']);
			flash(urlencode($trade_info['Name'].$tmp_status[$tmp_key]));
		}
		if($trade_info['require_membertype']>0){
			if(empty($pb_userinfo['user_type'])) {
				flash("no_perm");
			}
		}
		$t_point = intval($trade_info['require_point']);
		if($t_point>0){
			if($pb_userinfo['points']<$t_point){
			    flash("not_enough_point");
			}else{
			    $sql = "update {$this->table_prefix}members set credits=credits-".$t_point;
			    $this->dbstuff->Execute($sql);
			}
		}
	}
	
	function Delete($ids, $conditions = array())
	{
		$condition = array();
		if (is_array($ids)) {
			$condition[] = "id IN (".implode(",", $ids).")";
		}else{
			$condition[] = "id=".$ids;
		}
		$condition = am($condition, $conditions);
		$this->setCondition($condition);
		$this->dbstuff->Execute("DELETE FROM {$this->table_prefix}trades,{$this->table_prefix}tradefields USING {$this->table_prefix}trades LEFT JOIN {$this->table_prefix}tradefields ON {$this->table_prefix}tradefields.trade_id={$this->table_prefix}trades.id ".$this->getCondition());
		return true;
	}
	
	function Add($params = '')
	{
		$result = false;
		if (!empty($this->params['expire_days'])) {
			$trade_controller = & Trade::getInstance();
			if (array_key_exists($this->params['expire_days'],$trade_controller->getOfferExpires())) {
				$this->params['data']['trade']['expire_time'] = $this->timestamp+(24*3600*$_POST['expire_days']);
				$this->params['data']['trade']['expire_days'] = $_POST['expire_days'];
			}else{
				$this->params['data']['trade']['expire_time'] = $this->timestamp+(24*3600*10);
				$this->params['data']['trade']['expire_days'] = 10;
			}
		}
		$this->params['data']['trade']['submit_time'] = $this->params['data']['trade']['created'] = $this->params['data']['trade']['modified'] = $this->timestamp;
		$this->params['data']['trade']['ip_addr'] = pb_get_client_ip('str');
		if ($this->params['data']['trade']['keywords']) {
			$this->params['data']['trade']['keywords'] = pb_convert_comma($this->params['data']['trade']['keywords']);
		}
		if (isset($this->params['data']['trade']['title'])) {
			$trade_info = $this->params['data']['trade'];
		    $result = $this->save($trade_info);
		    $key = $this->table_name."_id";
		    $last_tradeid = $this->$key;
			$_this = & Tradefields::getInstance();
			$_this->params['data']['tradefield']['trade_id'] = $last_tradeid;
			$tradefield_info = $_this->params['data']['tradefield']+$this->params['data']['tradefield'];
			$_this->primaryKey = "trade_id";
			$_this->save($tradefield_info);
		}
		return $result;
	}
	
	function refresh($ids)
	{
		if (empty($ids)) {
			return false;
		}
		if (is_array($ids)) {
			$condition = "id IN (".implode(",", $ids).")";
		}else{
			$condition = "id=".$ids;
		}
		return $this->dbstuff->Execute("UPDATE {$this->table_prefix}trades SET expire_time=expire_days*86400+".$this->timestamp.",submit_time=".$this->timestamp." WHERE ".$condition);
	}
	
	function formatResult($result)
	{
		global $_PB_CACHE, $rewrite_able;
		if(class_exists("Trade")){
			$trade_controller = new Trade();
		}else{
			uses("trade");
			$trade_controller = new Trade();
		}
		if(!empty($result)){
			if (empty($_PB_CACHE['trusttype'])) {
				require(CACHE_PATH. 'cache_trusttype.php');
			}
			$count = count($result);
			for ($i=0; $i<$count; $i++){
				$result[$i]['pubdate'] = @date("Y-m-d", $result[$i]['submit_time']);
				$result[$i]['content'] = strip_tags($result[$i]['content']);
				$result[$i]['url'] = $trade_controller->rewrite($result[$i]['id'], $result[$i]['type_id']);
				if(!empty($result[$i]['membergroup_id'])) {
					$result[$i]['gradeimg'] = 'images/group/'.$_PB_CACHE['membergroup'][$result[$i]['membergroup_id']]['avatar'];
					$result[$i]['gradename'] = $_PB_CACHE['membergroup'][$result[$i]['membergroup_id']]['name'];
				}
				$result[$i]['image'] = pb_get_attachmenturl($result[$i]['picture'], '', 'middle');
				$trusttype_images = null;
				if(!empty($result[$i]['trusttype_ids'])){
					$tmp_trusttype = explode(",", $result[$i]['trusttype_ids']);
					foreach ($tmp_trusttype as $val) {
						$trusttype_images.='<img src="'.$_PB_CACHE['trusttype'][$val]['avatar'].'" alt="'.$_PB_CACHE['trusttype'][$val]['name'].'" />';
					}
				}
				$result[$i]['trusttype'] = $trusttype_images;
			}
			return $result;
		}else{
			return null;
		}
	}
}
?>