<?php
/**
 * PHP 5.0.2 with Appserv 2.0.58
 * Zend Studio 5.2
 * @filesource		app/models/class.rank.php
 * @copyright		www.ualink.cn
 * @link
 * @package
 * @subpackage
 * @version
 * @author	 		Stevenchow811@163.com
 * @lastmodified	Tue Apr 17 14:49:21 CST 200714:49:21
 * @description		用户积分、评分说明：最高为100分
 * 会员的分数:Member(rank)=(用户被评价的总的次数×评价的分数的总和)/(用户被评价的总的次数×5)，然后取百分数，乘以100
 */
 class Ranks extends UaModel {
 	
 	var $name = "Rank";

 	function Ranks()
 	{
 		
 	}
}
?>