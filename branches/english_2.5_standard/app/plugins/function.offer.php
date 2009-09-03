<?php
/**
 * Note : The Software shall be used for Good, not Evil.
 * PHPB2B - As an open source b2b program.
 *
 * Permission is hereby granted to use this version of the library under the
 * following license:
 *
 * --
 * Copyright (c) 2006-2009 Ualink (http://www.phpb2b.com/)
 *
 * All rights granted under this License are granted for the term of copyright on
 * the Program, and are irrevocable provided the stated conditions are met. This
 * License explicitly affirms your unlimited permission to run the unmodified Program.
 * The output from running a covered work is covered by this License only if the
 * output, given its content, constitutes a covered work.
 * This License acknowledges your rights of fair use or other equivalent, as provided
 * by copyright law.
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * --
 *
 * @package phpb2b
 * @copyright 2009 Ualink <phpb2b@hotmail.com> (http://www.phpb2b.com/)
 * @license http://www.opensource.org/licenses/gpl-license.php GPL License
 * @created Mon Jun 22 16:42:11 CST 2009
 * @link http://sourceforge.net/projects/php-b2b/
 * @version $Id$
 */
function smarty_function_offer($params){
	global $g_db;
	global $smarty, $theme_name,$time_stamp;
	$is_bold = false;
	$conditions = array();
	$limit = null;
	$tpl_file = (isset($params['templet']))?"block.".$params['templet'].".html":"block.offer_default.html";
	extract($params);
	if (!class_exists("Trades")) {
		uses("trade");
		$trade = new Trades();
	}else{
	    $trade = new Trades();
	}
	$conditions[] = "Trade.status=1";
	$fields = "Trade.id as OfferId,Trade.type_id as OfferTypeId,Trade.topic as OfferTopic,Trade.topic as Title,Trade.picture as OfferPicture,Trade.created as CreateDate,Trade.submit_time as PublishTime,Trade.expire_time as OfferExpireDate,Trade.html_file_id as HtmlFileName,Trade.clicked as OfferClick,content as TradeContent";

	if(isset($params['id'])){
		$result = $trade->read($fields, intval($params['id']));
	}else{
		if (isset($params['type'])) {
			if($params['type']=="image"){
				$conditions[] = "Trade.picture!=''";
				$tpl_file = "block.default.image.html";
			}elseif ($params['type']=="buy" || $params['type']=="qiugou"){
			    $offer_keys = $trade->getTradeTypeKeys("buy");
			    $conditions[] = "Trade.type_id in ".$offer_keys;
			}elseif ($params['type']=="sell" || $params['type']=="gongying"){
			    $offer_keys = $trade->getTradeTypeKeys("sell");
			    $conditions[] = "Trade.type_id in ".$offer_keys;
			}
			if ($params['type']=="urgent"){
				$conditions[] = "Trade.if_urgent='1'";
			}
			if ($params['type']=="company") {
				$conditions[] = "Trade.company_id>0";
			}
			if ($params['type']=="commend") {
				$conditions[] = "Trade.if_commend=1";
			}
		}
		if(isset($params['expday'])){
			$conditions[] = "Trade.expire_time<'".($params['expireday']*86400+$time_stamp)."'";
		}
		if(isset($params['subday'])){
			$conditions[] = "Trade.submit_time>'".($time_stamp-$params['expireday']*86400)."'";
		}
		if (isset($params['type_id'])) {
			$conditions[] = "Trade.type_id='".$params['type_id']."'";
		}
		if (isset($params['urgent'])) {
			$conditions[] = "Trade.if_urgent='1'";
		}
		if (isset($params['cash'])) {
			$conditions[] = "Trade.require_point>0";
		}
		if (isset($params['orderby'])) {
			$orderby = " order by ".trim($params['orderby']);
		}else{
		    $orderby = " order by Trade.modified desc";
		}
		if(isset($params['term'])){
			$trade->term = trim($params['term']);
		}
		$trade->setLimit($params['row'], $params['col'], $params['max']);
		$tmp_cond = implode(" and ", $conditions);
		$sql = "select ".$fields." from ".$trade->getTable(true)." where ".$tmp_cond.$orderby.$trade->getLimit();
		$result = $g_db->GetArray($sql);
	}
	if (isset($params['showtypename'])) {
		if ($params['showtypename']=="n") {
			$tpl_file = "block.default.html";
		}
	}
	$offer_typenames = $trade->getTradeTypes();
	$output = null;
	if (isset($params['isbold']) && !empty($result)) {
	    $is_bold = true;
	    $first_res = array_shift($result);
	    //da($first_res);
		$output.='			<div>
				<a href="'.URL.'offer/detail.php?id='.$first_res['OfferId'].'"><img src="'.URL.'attachment/'.$first_res['OfferPicture'].'.small.jpg" alt="'.$first_res['Title'].'" class="c_b padd4" /></a>
				<p>
					<a href="'.URL.'offer/detail.php?id='.$first_res['OfferId'].'" title="" class="str title">'.$first_res['Title'].'</a>
					<a href="'.URL.'offer/detail.php?id='.$first_res['OfferId'].'">'.utf_substr(strip_tags($first_res['TradeContent']), 120).'</a>
				</p>
			</div>
			<ul class="ul21">
';
	}
	for($i=0; $i<count($result); $i++){
	    if(PRETEND_HTML_LEVEL==0){
	        $url = URL."offer/detail.php?id=".$result[$i]['OfferId'];
	    }else{
	        $dt = getdate($result[$i]['CreateDate']);
	        $url = URL."offer/".$dt['year']."/".$dt['mon']."/".$dt['mday']."/".urlencode($result[$i]['Title'])."/";
	    }
	    $result[$i]['fulltitle'] = $result[$i]['Title'];
	    if (isset($params['titlelen'])) {
	    	$result[$i]['Title'] = utf_substr($result[$i]['Title'], $params['titlelen']);
	    }
    	if(!isset($params['block'])){
    		$op = $smarty->fetch($theme_name."/".$tpl_file, null, null, false);
    	}else{
    		$op = trim($params['block']);
    	}
		$var = (isset($params['showdate']))?"":date("m/d", $result[$i]['PublishTime']);
    	$op = str_replace(array("[link:title]", "[field:title]", "[img:thumb]", "[img:src]", "[field:type]", "[field:pubdate]", "[link:type]", "[field:fulltitle]"), array($url, $result[$i]['Title'], URL."attachment/".$result[$i]['OfferPicture'].".thumb.jpg", URL."attachment/".$result[$i]['OfferPicture'], $offer_typenames[$result[$i]['OfferTypeId']], $var, $typelink, $result[$i]['fulltitle']), $op);
	    //$output.=$trade->checkTerminal($i);
	    $output.=$op;
	}
	if ($is_bold) {
		$output.='</ul>';
	}
	unset($result);
	echo $output;
}
?>


