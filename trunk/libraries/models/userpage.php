<?php
class Userpages extends PbModel {
	var $name = "Userpage";
	var $current_li = null;
	var $url_container = null;
	var $pb_version = null;

	function getLi()
	{
		return $this->current_li;
	}

	function setLi($li_id)
	{

		switch ($li_id) {
			case 1:
				$this->current_li = "current_li_name_buy";

				break;
			case 2:
				$this->current_li = "current_li_name_sell";
				break;
			case 3:
				$this->current_li = "current_li_name_company";
				break;
			case 4:
				$this->current_li = "current_li_name_product";
				break;
			case 5:
				$this->current_li = "current_li_name_news";
				break;
			case 6:
				$this->current_li = "current_li_name_market";
				break;
			case 8:
				$this->current_li = "current_li_name_fair";
				break;
			case 9:
				$this->current_li = "current_li_name_hr";
				break;
			default:
				$this->current_li = "current_li_name_start";
				break;
		}
	}

	function setUrlContainer($static_level){
		global $media_paths, $g_db, $tb_prefix;
		$tmp_contain = array();
		$reg_filename = $g_db->GetOne($sql = "select valued from {$tb_prefix}settings where variable='reg_filename'");
		$reg_filename = (empty($reg_filename))?"register.php":$reg_filename;
		$post_filename = $g_db->GetOne("select valued from {$tb_prefix}settings where variable='post_filename'");
		$post_filename = (empty($post_filename['valued']))?"offer/post.php":$post_filename;
		switch ($static_level) {
			case 1:
				$tmp_contain['index'] = URL."index.html";
				$tmp_contain['buy'] = URL."htmls/offer/buy/";
				$tmp_contain['sell'] = URL."htmls/offer/sell/";
				$tmp_contain['company'] = URL."htmls/company/";
				$tmp_contain['product'] = URL."htmls/product/";
				$tmp_contain['news'] = URL."htmls/news/";
				$tmp_contain['hr'] = URL."htmls/hr/";
				$tmp_contain['market'] = URL."htmls/market/";
				$tmp_contain['fair'] = URL."htmls/fair/";
				$tmp_contain['user'] = URL."htmls/user/";
				$tmp_contain['apply_friendlink'] = URL."htmls/user/apply_friendlink.html";
				$tmp_contain['register'] = URL."htmls/user/register.html";
				$tmp_contain['artical'] = URL."htmls/user/artical.html";
				$tmp_contain['logging'] = URL."user/logging.html";
				$tmp_contain['post'] = URL."htmls/offer/post.html";
				$tmp_contain['common'] = URL;
				break;
			default:
				$tmp_contain['index'] = URL;
				$tmp_contain['buy'] = URL."buy/";
				$tmp_contain['sell'] = URL."sell/";
				$tmp_contain['company'] = URL."company/";
				$tmp_contain['product'] = URL."product/";
				$tmp_contain['news'] = URL."news/";
				$tmp_contain['hr'] = URL."hr/";
				$tmp_contain['market'] = URL."market/";
				$tmp_contain['fair'] = URL."fair/";
				$tmp_contain['user'] = URL."user/";
				$tmp_contain['apply_friendlink'] = URL."user/apply_friendlink.php";
				$tmp_contain['register'] = URL."user/".$reg_filename;
				$tmp_contain['artical'] = URL."agreement.php";
				$tmp_contain['logging'] = URL."user/logging.php";
				$tmp_contain['post'] = URL.$post_filename;
				$tmp_contain['common'] = URL;
				break;
		}
		$this->url_container = $tmp_contain;
	}

	function getUrlContainer(){
		return $this->url_container;
	}

	function setPbVersion($xml_filename){
		$r = array();
		$rssurl = $xml_filename;
		$result = file_get_contents($rssurl);
		if (empty($result) || !$result) {
			return  false;
		}
		$xml_parser = xml_parser_create("utf-8");
		xml_parser_set_option($xml_parser,XML_OPTION_CASE_FOLDING,0);
		xml_parser_set_option($xml_parser,XML_OPTION_SKIP_WHITE,1);
		xml_parse_into_struct($xml_parser,$result,$values,$tags);
		xml_parser_free($xml_parser);
		array_pop($values);
		array_shift($values);
		foreach($values as $key=>$val){
			if($val['tag']=="public"){
				$r['public'] = array("ver"=>$val['attributes']['ver'], "build"=>$val['attributes']['build']);
			}elseif($val['tag']=="profession"){
				$r['profession'] = array("ver"=>$val['attributes']['ver'], "build"=>$val['attributes']['build']);
			}
		}
		$this->pb_version = $r;
		unset($result);
	}

	function getPbVersion(){
		return $this->pb_version;
	}
}
?>