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
 * @version $Id: block.news.php 472 2009-12-27 04:12:35Z steven $
 */
function smarty_block_news($params, $content, &$smarty) {
	global $cookiepre, $rewrite_able;
	if ($content === null) return;
	$conditions = array();
	if (class_exists("News")) {
		$news = new Newses();
	}else{
	    uses("news");
	    $news = new Newses();
	}
	$orderby = array();
	require(CACHE_PATH. "cache_newstype.php");
	$conditions[] = "n.status=1";
	if(isset($params['type'])) {
		$type = explode(",", $params['type']);
		$type = array_unique($type);
		foreach ($type as $val) {
			switch ($val) {
				case 'image':
					$conditions[] = "n.picture!=''";
					break;
				case 'hot':
					$orderby[] = 'clicked DESC';
				default:
					break;
			}
		}
	}
	if (isset($params['tag'])) {
		$conditions[] = "n.title like '%".$params['tag']."%'";
	}
	if (isset($params['typeid'])) {
		$conditions[] = "n.type_id=".$params['typeid'];
	}
	if (isset($params['orderby'])) {
		$orderby[] = trim($params['orderby']);
	}else{
		$orderby[] = "id DESC ";
	}
	$news->setOrderby($orderby);
	$news->setCondition($conditions);
	$row = $col = 0;
	if (isset($params['row'])) {
		$row = $params['row'];
	}
	if (isset($params['col'])) {
		$col = $params['col'];
	}
	$news->setLimitOffset($row, $col);
	$sql = "SELECT id,title as fulltitle,title,picture,type_id,created,content as fullcontent,content FROM {$news->table_prefix}newses n ".$news->getCondition().$news->getOrderby().$news->getLimitOffset();
	$result = $news->dbstuff->GetArray($sql);
	$return = null;
	if (!empty($result)) {
		$i_count = count($result);
		for ($i=0; $i<$i_count; $i++){
			$style = null;
			$dt = @getdate($result[$i]['created']);
			$url = ($rewrite_able)? "news/detail/".$result[$i]['id'].".html":"news/detail.php?id=".$result[$i]['id'];
			if (isset($params['titlelen'])) {
	    		$result[$i]['title'] = utf_substr($result[$i]['title'], $params['titlelen']);
	    	}	    	
	    	$result[$i]['content'] = strip_tags($result[$i]['content']);
	    	if (isset($params['infolen'])) {
	    		$result[$i]['content'] = utf_substr($result[$i]['content'], $params['infolen']);
	    	}
	    	if (isset($params['magic']))  {
	    		if ($i==0){
	    			if(!empty($result[$i]['picture'])) {
	    				$style = " style=\"height:70px; background:url(".URL."attachment/".$result[$i]['picture'].".small.jpg".") no-repeat; padding:0 0 0 90px;overflow:hidden; width:120px;\"";
	    			}else{
	    				$style = " style=\"height:70px; background:url(".URL."images/nopic.small.gif".") no-repeat; padding:0 0 0 90px;\"";
	    			}
	    			$result[$i]['url'] = "<h3><a href='{$url}'>".$result[$i]['title']."</a></h3>
				   <p>".$result[$i]['content']."</p>";
	    		}else{
	    			$result[$i]['url'] = "<a href='{$url}'>".$result[$i]['title']."</a>";
	    		}
			}
			$return.= str_replace(array("[link:title]", "[field:title]", "[img:src]", "[field:fulltitle]", "[field:typename]", "[field:pubdate]", "[field:id]", "[field:type_id]", "[field:style]", "[field:url]"), array($url, $result[$i]['title'], "attachment/".$result[$i]['picture'].".small.jpg", $result[$i]['fulltitle'], $_PB_CACHE['newstype'][$result[$i]['type_id']], @date("Y-m-d", $result[$i]['created']),$result[$i]['id'], $result[$i]['type_id'], $style, $result[$i]['url']), $content);
		}
	}
	return $return;
}
?>