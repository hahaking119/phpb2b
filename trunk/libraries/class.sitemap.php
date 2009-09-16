<?php
class sitemap {

	var $s = "";

	function sitemap($encoding = '') {
		
		if(empty($encoding)){
			$encoding = "UTF-8";
			}

		$this->s = "<?xml version=\"1.0\" encoding=\"$encoding\"?>\n";
		$this->s .= "<urlset xmlns=\"http://www.google.com/schemas/sitemap/0.84\">\n";
		}

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
	function addurl($loc, $lastmod = '', $changefreq = '', $priority = '') {

		$loc = htmlentities($loc,ENT_QUOTES);
		$this->s .= "\t\t<url>\n\t\t\t<loc>$loc</loc>\n";

		if(!empty($lastmod)){
			$this->s .= "\t\t\t<lastmod>$lastmod</lastmod>\n";
			}

		if(!empty($changefreq)){
			$this->s .= "\t\t\t<changefreq>$changefreq</changefreq>\n";
			}

		if(!empty($priority)){
			$this->s .= "\t\t\t<priority>$priority</priority>\n";
			}
		$this->s .= "\t\t</url>\n\n";
		}
	
	//如果没有填写文件名则直接输出
	function buildsitemap($filename = "") {
		$this->s .= "\t</urlset>\n";
		if(empty($filename)){
			header("Content-Type: text/xml");
			echo $this->s;
			}else{
			$this->save2file($filename);
			return true;
			}
		}

	function save2file($filename) {
		$fp = @fopen($filename,"w+") or die(sprintf("建立文件1%失败",$filename));
		@fwrite($fp,$this->s);
		@fclose($fp);
		}
}
?>