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
 	
 	function getOfferExpires()
 	{
 		@require(CACHE_PATH. "type_offer_expire.php");
 		return $_PB_CACHE['offer_expire'];
 	}
 	
 	function rewrite($id, $typeid = 0, $title = null, $dt = null)
 	{
		$url = null;
		global $rewrite_able, $rewrite_compatible;
		if ($rewrite_able) {
			if ($rewrite_compatible && !empty($title)) {
				$url = $this->getModulenameById($typeid)."/".rawurlencode($title)."/";
			}else{
				$url = $this->getModulenameById($typeid)."/detail/".$id.".html";
			}
		}else{
			$url = "offer/detail.php?id=".$id;
		}
		return $url; 		
 	}
 	
 	function getModulenameById($typeid)
 	{
 		$module_name = null;
 		switch ($typeid) {
 			case 1:
 				$module_name = "buy";
 				break;
 			case 2:
 				$module_name = "sell";
				break;
 			default:
 				$module_name = "offer";
 				break;
 		}
 		return $module_name;
 	}
	
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
	
 	function getTradeTypes()
 	{
		@require(CACHE_PATH. "cache_offertype.php");
		$this->types = $_PB_CACHE['offertype'];
		return $_PB_CACHE['offertype'];
 	}

	function getTradeTypeNames(){
		return $this->type_names;
	}

	function setTradeTypeNames(){
		@require(CACHE_PATH. "cache_offertype.php");
		$this->type_names = $_PB_CACHE['offertype'];
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