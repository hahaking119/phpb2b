<?php
$inc_path = null;
require($inc_path."global.php");
include_once(SITE_ROOT. './app/include/feedcreator.class.php');
//header('Content-Type: text/xml');
//header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
//header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
//header('Pragma: public');
$rss = new UniversalFeedCreator();
$rss->useCached();
$rss->title = $_SETTINGS['sitename'];
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