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
 * @version $Id: pb_view.php 462 2009-12-27 03:20:41Z steven $
 */
class PbView extends PbObject
{
	var $admin_dir = 'pb-admin';
	var $office_dir = 'office-room';
	var $homepage_file_name = "index.php";
	var $titles = array();
	var $pageTitle = null;
	var $url_container = null;
	var $webroot;
	var $here = null;
	var $position = array();
	var $addParams;
	var $metaKeyword;
	var $metaDescription;
	var $caching = false;

	function PbView(){
		global $_PB_CACHE;
		if (!empty($_GET['page'])) {
			$this->addParams = "&page=".intval($_GET['page']);
		}
		$this->setPosition($_PB_CACHE['setting']['site_name'], URL);
	}

	function __construct(){
		$this->PbView();
	}
	
	function setMetaDescription($meta_description)
	{
		$this->metaDescription = utf_substr(strip_tags($meta_description, 100));
	}
	
	function setMetaKeyword($meta_keyword)
	{
		$this->metaKeyword = str_replace(array(), ",", $meta_keyword);
	}	

    function setTitle($title, $image = 0)
    {
    	$this->titles[] = $title.($image?"[".L('have_picture', 'tpl')."]":null);
    }

    function getTitle($seperate = " &laquo; ")
    {
        $pageTitle = null;
    	krsort($this->titles);
    	$pageTitle = implode($seperate, $this->titles);
    	if (strpos($pageTitle, $seperate) == 0) {
    		;
    	}
    	$this->pageTitle = $pageTitle;
    	return $pageTitle;
    }
    
	function bread_compare($a, $b){
	    if ($a['displayorder'] == $b['displayorder']) return 0;
	    return ($a['displayorder'] < $b['displayorder']) ? -1 : 1;
	}
	
	function queryString($q, $extra = array(), $escape = false) {
		if (empty($q) && empty($extra)) {
			return null;
		}
		$join = '&';
		if ($escape === true) {
			$join = '&amp;';
		}
		$out = '';
	
		if (is_array($q)) {
			$q = array_merge($extra, $q);
		} else {
			$out = $q;
			$q = $extra;
		}
		$out .= http_build_query($q, null, $join);
		if (isset($out[0]) && $out[0] != '?') {
			$out = '?' . $out;
		}
		return $out;
	}

    function setPosition($title, $url = null, $displayorder = 0, $additonalParams = array())
    {
        $this->position[] = array('displayorder'=>$displayorder, 'title'=>$title, 'url'=>$url, 'params'=>$additonalParams);
    }

    function getPosition($seperate = " &gt; ")
    {
    	$position = array();
    	$current_position = null;
    	$positions = $this->position;
        if (!empty($positions)) {
        	//uasort($positions, array("PbView", "bread_compare"));
	        foreach ($positions as $key=>$val){
	            if(!empty($val['url'])) {
	                if(isset($val['params'])) $position[] = "<a href='".$val['url'].$this->queryString($val['params'])."' target='_self' title='".$val['title']."'>".$val['title']."</a>";
	                else $position[] = "<a href='".$val['url']."' target='_self' title='".$val['title']."'>".$val['title']."</a>";
	            }else {
	                $position[] = $val['title'];
	            }
	        }
	        $current_position = L("your_current_position", "tpl").implode($seperate, $position);
	        $this->here = $current_position.$seperate;
        }
        return $this->here;
    }
    
	function setUrlContainer($static_level){
		global $_PB_CACHE;
		$tmp_contain = array();
		$reg_filename = (empty($_PB_CACHE['setting']['reg_filename']))?"register.php":$_PB_CACHE['setting']['reg_filename'];
		$post_filename = (empty($_PB_CACHE['setting']['post_filename']))?"post.php":$_PB_CACHE['setting']['post_filename'];
		switch ($static_level) {
			default:
				$tmp_contain['index'] = "index.php?sid=".pb_radom(6);
				$tmp_contain['buy'] = "buy/";
				$tmp_contain['sell'] = "sell/";
				$tmp_contain['company'] = "company/";
				$tmp_contain['product'] = "product/";
				$tmp_contain['news'] = "news/";
				$tmp_contain['hr'] = "hr/";
				$tmp_contain['market'] = "market/";
				$tmp_contain['fair'] = "fair/";
				$tmp_contain['user'] = "member/";
				$tmp_contain['apply_friendlink'] = "friendlink.php";
				$tmp_contain['register'] = "member/".$reg_filename;
				$tmp_contain['artical'] = "agreement.php";
				$tmp_contain['logging'] = "logging.php";
				$tmp_contain['post'] = $post_filename;
				$tmp_contain['common'] = URL;
				break;
		}
		$this->url_container = $tmp_contain;
	}

	function getUrlContainer(){
		return $this->url_container;
	}
	
	function Start()
	{
		global $topleveldomain_support, $pdb, $tb_prefix;
		//检测是否开启了顶级域名支持
		if ($topleveldomain_support) {
			$host = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
			$result = $pdb->GetRow("SELECT id,cache_spacename FROM {$tb_prefix}companies WHERE topleveldomain='".$host."' AND status='1'");
			if (!empty($result)) {
				pheader("HTTP/1.1 301 Moved Permanently");
				pheader("location:".URL."space.php?id=".$result['id']);
				exit();
			}
		}
		//如果是，则定向到企业商铺
		formhash();
	}
}
?>