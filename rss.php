<?php
define('CURSCRIPT', 'rss');
require("libraries/common.inc.php");
include_once(PHPB2B_ROOT. './libraries/feedcreator.class.php');
$rss = new UniversalFeedCreator();
$rss->useCached();
$rss->title = $_PB_CACHE['setting']['site_name'];
$rss->description = "daily news from the PHP scripting world";
$rss->link = URL."news";
$rss->syndicationURL = URL."rss.php";
$image = new FeedImage();
$image->title = "Your logo here";
$image->url = URL."images/logo.gif";
$image->link = URL;
$image->description = "Feed provided by dailyphp.net. Click to visit.";
$rss->image = $image;
$rss->saveFeed("RSS1.0", "data/feed/rss.xml");
?>