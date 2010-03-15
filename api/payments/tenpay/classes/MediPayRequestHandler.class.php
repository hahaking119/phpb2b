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

require ("RequestHandler.class.php");

class MediPayRequestHandler extends RequestHandler {
	
	function __construct() {
		$this->MediPayRequestHandler();
	}
	
	function MediPayRequestHandler() {
		//默认支付网关地址
		$this->setGateURL("https://www.tenpay.com/cgi-bin/med/show_opentrans.cgi");	
	}
	
	/**
	*@Override
	*初始化函数，默认给一些参数赋值。
	*/
	function init() {
		//自定参数，原样返回
		$this->setParameter("attach", "1");
		
		//平台商帐号
		$this->setParameter("chnid",  "");
		
		//任务代码
		$this->setParameter("cmdno", "12");
		
		//编码类型 1:gbk 2:utf-8
		$this->setParameter("encode_type", "2");
		
		//交易说明，不能包含<>’”%特殊字符
		$this->setParameter("mch_desc", "");
		
		//商品名称，不能包含<>’”%特殊字符
		$this->setParameter("mch_name", "");
		
		//商品总价，单位为分。
		$this->setParameter("mch_price",  "");
		
		//回调通知URL
		$this->setParameter("mch_returl",  "");
		
		//交易类型：1、实物交易，2、虚拟交易
		$this->setParameter("mch_type",  "");
		
		//商家的定单号
		$this->setParameter("mch_vno",  "");
		
		//是否需要在财付通填定物流信息，1：需要，2：不需要。
		$this->setParameter("need_buyerinfo",  "");
		
		//卖家财付通帐号
		$this->setParameter("seller",  "");
		
		//支付后的商户支付结果展示页面
		$this->setParameter("show_url",  "");
		
		//物流公司或物流方式说明
		$this->setParameter("transport_desc",  "");
		
		//需买方另支付的物流费用
		$this->setParameter("transport_fee",  "");
		
		//版本号
		$this->setParameter("version",  "2");
		
		//摘要
		$this->setParameter("sign",  "");
		
	}
	
}

?>