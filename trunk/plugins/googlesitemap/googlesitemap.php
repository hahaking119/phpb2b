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
if(!defined('IN_PHPB2B')) exit('Not A Valid Entry Point');
$pb_plugin_name = "googlesitemap";//必须的参数，即为文件夹的名称
/**
 * 处理一些其他操作
 */
if (isset($_POST['save'])) {
	//生成googlesitemap
	pb_submit_check("pluginvar");//检查提交的必要参数
	if(empty($_POST['pluginvar']['lastmod'])){
		$_POST['pluginvar']['lastmod'] = date("Y-m-d H:i:s");
	}
	buildsitemap($_POST['pluginvar']['lastmod']);
}
function buildsitemap($lastmod,$encoding = '') {
	/*****************
	* $loc			url地址 符号要转义
	符号 	& 	&amp;
	单引号 	' 	&apos;
	双引号 	" 	&quot;
	大于 	> 	&gt;
	小于 	< 	&lt;
	* $lastmod		修改时间 W3C Datetime 可以使用YYYY-mm-dd
	* $changefreq	更新频率 always hourly daily weekly monthly yearly never
	* $priority		重要性 0.1-1.0之间
	*******************/
	$s='';
	$filename = PHPB2B_ROOT."sitemap.xml";
	if(empty($encoding)){
		$encoding = "UTF-8";
	}
   $locs = array(array('loc'=>'http://localhost/phpb2b/index.php','changefreq'=>'always','priority'=>'0.9'),array('loc'=>'http://localhost/phpb2b/buy','changefreq'=>'always','priority'=>'0.8'),array('loc'=>'http://localhost/phpb2b/sell','changefreq'=>'always','priority'=>'0.8'));
	$s = "<?xml version=\"1.0\" encoding=\"$encoding\"?>\n";
	$s .= "<urlset xmlns=\"http://www.google.com/schemas/sitemap/0.84\">\n";
      foreach($locs as $key=>$val){
      	 $url=htmlentities($val['loc'],ENT_QUOTES);
      	 $s .= "\t\t<url>\n\t\t\t<loc>".$url."</loc>\n";
      	 $s .= "\t\t\t<lastmod>".$lastmod."</lastmod>\n";
      	 $s .= "\t\t\t<changefreq>".$val['changefreq']."</changefreq>\n";
      	 $s .= "\t\t\t<priority>".$val['priority']."</priority>\n";
      	 $s .= "\t\t</url>\n";
      }
    
	$s .= "\n\t</urlset>\n";
	$fp = @fopen($filename,"w+") or die(sprintf("建立文件1%失败",$filename));
	@fwrite($fp,$s);
	@fclose($fp);
}
?>