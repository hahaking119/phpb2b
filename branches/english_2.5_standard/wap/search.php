<?
header("Content-type: text/vnd.wap.wml; charset=utf-8");
echo("<?xml version=\"1.0\"?>\n");
echo("<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.1//EN\" \"http://www. wapforum.org/DTD/wml_1.1.xml\">\n\n");
?>
<wml>
	<card id="search" title="搜索信息">
		<p>
		<input name="variable" title="请输入关键词" type="text" value="请输入关键词" emptyok="false" size="25" maxlength="25" tabindex="1"/>
		<br />
		<a href="search.php">开始搜索</a>
		<br />
		</p>
	</card>
</wml>