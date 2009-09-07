<?php
 class Trades extends UaModel {
 	var $name = "Trade";
 	var $company_trade_cols = "Trade.id AS TID,Trade.id AS TradeId,topic AS Name,content AS Description,company_id AS CompanyID,Trade.member_id as MemberId,Trade.picture AS TradePicture,Trade.status AS TradeStatus,Trade.type_id AS trade_type,Trade.created AS CreateDate,Trade.submit_time AS PublishDate,expire_time AS ExpireDate,Company.name AS CompanyName,Company.link_man AS CompanyLinkMan,boss_name AS LinkName,CONCAT(telcode,telzone,tel) AS CompTel";
 	var $mini_trade_cols = "Trade.id AS ID,Trade.type_id AS trade_type,Trade.member_id AS TradeMemberId,Trade.company_id AS TradeCompanyId,Trade.topic AS Name,Trade.content AS Content,submit_time AS PublishTime,Trade.picture AS TradePicture,Trade.expire_time AS TradeExpiretime,Trade.status AS TradeStatus,html_file_id,require_point,require_membertype ";
	var $type_names;
	var $trade_cate = null;
	var $trade_type_sign_id = null;
	var $industry_amount_name = null;

 	function setTradeCat($trade_type_id)
 	{
 		$buy_s = array_keys($this->buy_types);
 		$sell_s = array_keys($this->sell_types);
 		if (in_array($trade_type_id, $buy_s)) {
 			$return_type = "buy";
			$this->trade_type_sign_id = 1;
 		}elseif (in_array($trade_type_id, $sell_s)){
 			$return_type = "sell";
			$this->trade_type_sign_id = 2;
 		}else {}
		$this->trade_cate = $return_type;
		$this->industry_amount_name = $return_type."_amount";
 		return $return_type;
 	}

	function getTradeCat(){
		return $this->trade_cate;
	}

 	function Trades()
 	{

 	}

 	function getTradeTypes()
 	{
		$this->setTradeTypeNames();
 		$tmp_buytypes = $this->buy_types;
 		$tmp_selltypes = $this->sell_types;
 		$tmp_types = $tmp_buytypes + $tmp_selltypes;
 		return $tmp_types;
 	}

 	function getTradeTypeKeys($params)
 	{
 		if($params=="buy"){
			$trade_type = implode("','",array_keys($this->buy_types));
 		}elseif($params=="sell"){
 			$trade_type = implode("','",array_keys($this->sell_types));
 		}else{
			$trade_type = implode("','",array_keys($this->getTradeTypes()));
		}
		$trade_type = "('".$trade_type."')";
		return $trade_type;
 	}

	function getTradeTypeNames(){
		return $this->type_names;
	}

	function setTradeTypeNames(){
		$type_name = array();
		$buy_names = $this->buy_types;
		$sell_names = $this->sell_types;
		foreach($buy_names as $key_1=>$val_1){
			$type_name[$key_1] = "buy";
		}
		foreach($sell_names as $key_2=>$val_2){
			$type_name[$key_2] = "sell";
		}
		ksort($type_name);
		$this->type_names = $type_name;
	}

 	/**
 	 * 功能：检测功能信息是否过期
 	 *
 	 * @param unknown_type $expire_time
 	 * @return Boolean
 	 */
 	function Expired($expire_time)
 	{
 		$tmp_day = mktime(0,0,0,date("m") ,date("d"),date("Y"));
 		if ($tmp_day > $expire_time) {
 			return true;
 		}else {
 			return false;
 		}
 	}

	function getTodayPushAmount($trade_typeid){
		global $g_db;
		global $_SESSION;
 		$tmp_day = mktime(0,0,0,date("m") ,date("d"),date("Y"));
		if($trade_typeid>0){
			$this->setTradeCat($trade_typeid);
		}
		$sql = "select count(id) from ".$this->getTable()." where member_id=".$_SESSION['MemberID']." and submit_time>".$tmp_day." and type_id in ".$this->getTradeTypeKeys($this->getTradeCat());
		$return  = $g_db->GetOne($sql);
		return $return;
	}

	function test($params, $content, &$smarty, &$repeat){
		echo "<li>hello</li><li>function</li><li>asdf</li>";
	}

	function checkAccess($trade_info_un){
		$trade_info = unserialize($trade_info_un);
		global $tmp_status,$g_db;
		global $ua_user,$tb_prefix;
		if($trade_info['TradeStatus']!=1){
			$tmp_key = intval($trade_info['TradeStatus']);
			alert(urlencode($trade_info['Name'].$tmp_status[$tmp_key]));
		}elseif ($this->Expired($trade_info['ExpireDate'])){
			alert(urlencode($trade_info['Name'].lgg("have_expired")));
		}
		if($trade_info['require_membertype']>0){
			if(empty($ua_user['user_type'])) alert(urlencode(lgg("no_permission")));
		}
		$t_point = intval($trade_info['require_point']);
		if($t_point>0){
			if($ua_user['credit_point']<$t_point){
			    alert(urlencode(lgg("point_not_enough")));
			}else{
			    //reduce user's point
			    $sql = "update {$tb_prefix}members set credit_point=credit_point-".$t_point;
			    $g_db->Execute($sql);
			}
		}
	}
}