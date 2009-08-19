<?php
if (!function_exists("pageft")) {
	/**
	 * 对得到的数据分页
	 *
	 * @param 数据总数 $totle
	 * @param 每页显示数量 $displaypg
	 * @param 分页连接地址 $url
	 * @param 附加信息 $add
	 * @return 分页信息
	 */
    function pageft($totle, $displaypg = 20, $url = '', $add = false){
        global $firstcount, $pagenav, $_SERVER, $page_header;
        $GLOBALS["displaypg"] = $displaypg;
        if (isset($_GET['page'])) {
        	if (!intval($_GET['page'])) $page = 1;else $page = $_GET['page'];
        }else{
        	$page = 1;
        }
        if (!$url) {
            $url = $_SERVER["REQUEST_URI"];
        }
        // URL分析：
        $parse_url = parse_url($url);
        $url_query = $parse_url["query"]; //单独取出URL的查询字串
        if ($url_query) {
            // 因为URL中可能包含了页码信息，我们要把它去掉，以便加入新的页码信息。
            // 这里用到了正则表达式，请参考“PHP中的正规表达式”.
            $url_query = ereg_replace("(^|&)page=$page", "", $url_query);
            // 将处理后的URL的查询字串替换原来的URL的查询字串：
            $url = str_replace($parse_url["query"], $url_query, $url);
            // 在URL后加page查询信息，但待赋值：
            if ($url_query) $url .= "&page";
            else $url .= "page";
        }else {
			$url.="?page";
		}
        // 页码计算：
        $lastpg = ceil($totle / $displaypg); //最后页，也是总页数
        $page = min($lastpg, $page);
        $prepg = $page-1; //上一页
        $nextpg = ($page == $lastpg ? 0 : $page + 1); //下一页
        $firstcount = ($page-1) * $displaypg;
		if($firstcount<0) {
			$firstcount = 0;
		}
		$page_header = sprintf(lgg("page_header"), $lastpg, $displaypg, $page);
		$pagenav="";
		if($lastpg<=1) return false;
		$pagenav.="页次：<strong>".$page."</strong>/<strong>".$lastpg."</strong>";
		if($prepg) $pagenav.="<a href='$url=1'>首页</a><a href='$url=$prepg' class='pre'>上一页</a> ";
		$prevs = $page - 5; if ( $prevs <= 0) { $prevs = 1; }
		$prev = $prevs - 1; if ( $prev <= 0) {$prev = 1;}
		$nexts = $page + 4; if ( $nexts > $lastpg) { $nexts = $lastpg; }
		$next = $nexts + 1; if ( $next > $lastpg) {$next = $lastpg;}
		for ( $i = $prevs; $i <= $page-1; $i++ ) {
			$pagenav.="<a href='$url=$i'>$i</a>";
		}
		$pagenav.="<a class=\"over\">$page</a>";
		$title = null;
		for ( $i = $page+1; $i <= $nexts; $i++ ) {
			if($i==$lastpg) $title = "title=\"\"";
			$pagenav.="<a href='$url=$i' $title>$i</a>";
		}

		if($nextpg) $pagenav.=" <a href='$url=$nextpg'>下一页</a><a href='$url=$lastpg'>尾页</a> "; else $pagenav.=" ";
	}
}
?>