<?php
$inc_path = "../";$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './app/configs/db_session.php');
header("Content-Type: text/html; charset=".$charset);
require("session_cp.inc.php");
uses("trade","product", "news");
$trade = new Trades();
$news = new Newses();
$product = new Products();
require(LIB_PATH .'sitemap.class.php');
$sitemapfile = BASE_DIR."sitemap.xml";
$sitemap = new sitemap();
$result = $trade->findAll("Trade.id as ContentId,Trade.type_id as TradeType", null, "Trade.id desc", 0, $trade->findCount());
for($i=0; $i<count($result); $i++){
	$trade_type = intval($result[$i]['TradeType']);
	$tmp_types = $trade->buy_types;
	$tmp_types = array_keys($tmp_types);
	
	if (in_array($trade_type, $tmp_types)) {
		$tmp_dir = "buy";
	}else{
		$tmp_dir = "sell";
	}
	$result[$i]['loc'] = URL.$tmp_dir."/content.php?id=".$result[$i]['ContentId'];
	$result[$i]['lastmod'] = date("Y-m-d");
	$result[$i]['changefreq'] = 'weekly';
	$result[$i]['priority'] = '0.8';
}
$total_product = $product->findCount();
$prod_result = $product->findAll("Product.id as ContentId", null, null, 0, $total_product);
for($j=0; $j<$total_product; $j++){
	$prod_result[$j]['loc'] = URL."product/content.php?id=".$prod_result[$j]['ContentId'];
	$prod_result[$j]['lastmod'] = date("Y-m-d");
	$prod_result[$j]['changefreq'] = 'weekly';
	$prod_result[$j]['priority'] = '0.8';
}

$total_news = $news->findCount();
$news_result = $news->findAll("News.id as ContentId", null, null, 0, $total_news);
for($j=0; $j<$total_news; $j++){
	$news_result[$j]['loc'] = URL."news/detail.php?id=".$news_result[$j]['ContentId'];
	$news_result[$j]['lastmod'] = date("Y-m-d");
	$news_result[$j]['changefreq'] = 'weekly';
	$news_result[$j]['priority'] = '0.8';
}
$index_result[] = array('loc' => URL.'index.php','lastmod' => date("Y-m-d"),'changefreq' => 'daily','priority' => '0.9');
$index_result[] = array('loc' => URL.'buy/index.php','lastmod' => date("Y-m-d"),'changefreq' => 'daily','priority' => '0.9');
$index_result[] = array('loc' => URL.'sell/index.php','lastmod' => date("Y-m-d"),'changefreq' => 'daily','priority' => '0.9');
$index_result[] = array('loc' => URL.'news/index.php','lastmod' => date("Y-m-d"),'changefreq' => 'daily','priority' => '0.9');
$index_result[] = array('loc' => URL.'market/index.php','lastmod' => date("Y-m-d"),'changefreq' => 'daily','priority' => '0.9');
$index_result[] = array('loc' => URL.'product/index.php','lastmod' => date("Y-m-d"),'changefreq' => 'daily','priority' => '0.9');
$index_result[] = array('loc' => URL.'company/index.php','lastmod' => date("Y-m-d"),'changefreq' => 'daily','priority' => '0.9');
$data = array_merge($result, $prod_result, $news_result, $index_result);
foreach($data as $k=>$v) {
	$sitemap->addurl($v['loc'],$v['lastmod'],$v['changefreq'],$v['priority']);
}

if($sitemap->buildsitemap($sitemapfile)){
	echo 'Create successfully:<a href="'.URL.'sitemap.xml" target=_blank>'.$sitemapfile.'</a>';
	
}
?>