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
 * @version $Id: trade_controller.php 481 2009-12-28 01:05:06Z steven $
 */
class Trade extends PbController {
	var $name = "Trade";
	var $info;
	var $type_names;
	var $type_info;
	var $types;

 	var $offer_expires = array("10"=>"10天","30"=>"一个月","90"=>"三个月","180"=>"六个月");
	var $buy_types = array(1=>"求购", 4=>"合作", 5=>"招商");
	var $sell_types = array(2=>"供应", 3=>"代理", 6=>"加盟", 7=>"批发", 8=>"库存");
	
	function setInfoById($id)
	{
		$_this = & Trades::getInstance();
		$this->info = $_this->getInfoById($id);
	}
	
 	
	function &getInstance() {
		static $instance = array();
		if (!$instance) {
			$instance[0] =& new Trade();
		}
		return $instance[0];
	} 	 	
	
	function getInfoById()
	{
		return $this->info;
	}
	
	function setTypeInfo($typeid)
	{
		$types = $this->getTradeTypes();
		if (in_array($typeid, array_keys($types))) {
			$this->type_info['name'] = $this->types[$typeid];
		}else{
			$this->type_info['name'] = L("offer", 'tpl');
		}
	}
	
	function getTypeInfo()
	{
		return $this->type_info;
	}
	

 	function setTradeCat($trade_type_id)
 	{
 		$buy_s = array_keys($this->buy_types);
 		$sell_s = array_keys($this->sell_types);
 		if (in_array($trade_type_id, $buy_s)) {
 			$return_type = "buy";
 		}elseif (in_array($trade_type_id, $sell_s)){
 			$return_type = "sell";
 		}else {}
		$this->trade_cate = $return_type;
 		return $return_type;
 	}

	function getTradeCat(){
		return $this->trade_cate;
	}

 	function getTradeTypes()
 	{
		$this->setTradeTypeNames();
 		$tmp_buytypes = $this->buy_types;
 		$tmp_selltypes = $this->sell_types;
 		$tmp_types = $tmp_buytypes + $tmp_selltypes;
 		ksort($tmp_types);
 		$this->types = $tmp_types;
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

 	function Expired($expire_time)
 	{
 		$tmp_day = @mktime(0,0,0,date("m") ,date("d"),date("Y"));
 		if ($tmp_day > $expire_time) {
 			return true;
 		}else {
 			return false;
 		}
 	}	
}
?>