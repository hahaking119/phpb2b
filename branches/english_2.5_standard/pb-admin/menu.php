<?php
$menus = array(
0=>array(
		"ename"=>"home","url"=>"","cname"=>"Homepage","items"=>array(
			array("ename"=>"quickaction","show"=>true,"cname"=>"Quick Start","items"=>array(
				array("cname"=>"Member","url"=>"member.php?action=list"),
				array("cname"=>"Product Manager","url"=>"product.php?action=list"),
				array("cname"=>"Offer Manager","url"=>"trade.php?action=list"),
				array("cname"=>"Company Manager","url"=>"company.php?action=list"),
				array("cname"=>"Industry Manager","url"=>"industry.php?action=list"),
				array("cname"=>"Keyword Manager","url"=>"keyword.php?action=list"),
				array("cname"=>"Ad Manager","url"=>"ad.php?action=list"),
				array("cname"=>"Fair Manager","url"=>"fair.php?action=list"),
				array("cname"=>"Scheduled Tasks","url"=>"backup.php?action=home"),
				array("cname"=>"Basic Settings","url"=>"setting.php?action=basic"))),
				array("cname"=>"User logs","ename"=>"visitlog","items"=>array(
				array("cname"=>"User login log","url"=>"memberlog.php?action=list"),
				array("cname"=>"Operation Log","url"=>"adminlog.php?action=list"))
			)
		)
	),
1=>array(
		"ename"=>"basic","url"=>"setting.php?action=basic","cname"=>"System","items"=>array(
			array("ename"=>"setting","show"=>false,"cname"=>"System Settings","items"=>array(
				array("cname"=>"Basic Settings","url"=>"setting.php?action=basic"),
				array("cname"=>"Mail Settings","url"=>"setting.php?action=mail"),
				array("cname"=>"Registration and Access","url"=>"setting.php?action=permission"),
				array("cname"=>"Scheduled Tasks","url"=>"backup.php?action=home"),
				array("cname"=>"Google Sitemap","url"=>"sitemap.php?action=set"),
			)),
			array("ename"=>"iodatas","cname"=>"System","items"=>array(
				array("cname"=>"Importing Members","url"=>"io.php?action=import","title"=>"Integration software to import the data from the Member"),
				array("cname"=>"Update statistics","url"=>"stat.php","title"=>"Manually update the Web Statistics"),
			)),
	)),
2=>array(
		"ename"=>"datas","url"=>"trade.php?action=list","cname"=>"Repository","items"=>array(
			array("ename"=>"trade","show"=>false,"cname"=>"Leads","items"=>array(
				array("cname"=>"Supply and demand management","url"=>"trade.php?action=list"),
				array("cname"=>"Add the supply and demand","url"=>"trade.php?action=mod"),
				array("cname"=>"Supply and demand statistics(Beta)","url"=>"trade.php?action=stat"),
			)),
			array("ename"=>"product","cname"=>"Products","items"=>array(
				array("cname"=>"Product Management","url"=>"product.php?action=list"),
				array("cname"=>"Add Product","url"=>"product.php?action=mod"),

			)),
			array("ename"=>"company","cname"=>"Company Directory","items"=>array(
				array("cname"=>"Corporate library management","url"=>"company.php?action=list"),
				array("cname"=>"Add Company","url"=>"company.php?action=mod"),
				array("cname"=>"Type","url"=>"companytype.php?action=list"),
				array("cname"=>"Add a type","url"=>"companytype.php?action=mod"),
				array("cname"=>"Enterprise Video","url"=>"company.php?action=vcr"),
			)),
			array("ename"=>"market","cname"=>"Markets","items"=>array(
				array("cname"=>"Market Database Management","url"=>"market.php?action=list"),
				array("cname"=>"Add Market","url"=>"market.php?action=mod"),
			)),
			array("ename"=>"job","cname"=>"Jobs","items"=>array(
				array("cname"=>"Recruitment Information Management","url"=>"job.php?action=list"),
			)),
			array("ename"=>"member","cname"=>"Member Center","items"=>array(
				array("cname"=>"Member","url"=>"member.php?action=list"),
				array("cname"=>"Add Member","url"=>"member.php?action=mod"),
				array("cname"=>"Member Type","url"=>"membertype.php?action=list"),
				array("cname"=>"Add a type","url"=>"membertype.php?action=mod")
			)),
			array("ename"=>"member","cname"=>"Exhibition Information","items"=>array(
				array("cname"=>"Show Management","url"=>"fair.php?action=list"),
				array("cname"=>"Show Type Manager","url"=>"fairtype.php?action=list"),
				array("cname"=>"Add a Show","url"=>"fair.php?action=mod"),
				array("cname"=>"Add a Show Type","url"=>"fairtype.php?action=mod")
			)),
			array("ename"=>"order","cname"=>"User order","items"=>array(
				array("cname"=>"Order Management","url"=>"order.php?action=list")
			)),
			array("ename"=>"keyword","cname"=>"keyword","items"=>array(
				array("cname"=>"List of Keywords","url"=>"keyword.php?action=list"),
				array("cname"=>"Keyword bidding","url"=>"keywordship.php?action=list"),
				array("cname"=>"Add auction","url"=>"keywordship.php?action=mod")
			)),
)),
3=>array(
		"ename"=>"ads","url"=>"ad.php?action=list","cname"=>"Ads","items"=>array(
			array("ename"=>"ads","show"=>false,"cname"=>"Ad Position","items"=>array(
				array("cname"=>"Ad Position","url"=>"adzone.php?action=list"),
				array("cname"=>"Add Location","url"=>"adzone.php?action=mod"),
			)),
			array("ename"=>"ads","show"=>false,"cname"=>"Online advertising","items"=>array(
				array("cname"=>"Listings","url"=>"ad.php?action=list"),
				array("cname"=>"Add Ad","url"=>"ad.php?action=mod"),
			)),
		)),
4=>array(
		"ename"=>"news","url"=>"news.php?action=list","cname"=>"News","items"=>array(
			array("ename"=>"news","show"=>false,"cname"=>"News","items"=>array(
				array("cname"=>"All news","url"=>"news.php?action=list"),
				array("cname"=>"Add News","url"=>"news.php?action=mod"),
			)),
			array("ename"=>"newstypes","cname"=>"Information Type","items"=>array(
				array("cname"=>"Information Type","url"=>"newstype.php?action=list"),
				array("cname"=>"Add Category","url"=>"newstype.php?action=mod"),
			)),
			array("ename"=>"companynews","cname"=>"News","items"=>array(
				array("cname"=>"News Management","url"=>"companynews.php?action=list"),
			)),
			array("ename"=>"companymessages","cname"=>"Business review","items"=>array(
				array("cname"=>"Comment Management","url"=>"companymessage.php?action=list"),
			)),
	)),
5=>array(
		"ename"=>"services","url"=>"service.php?action=list","cname"=>"Online Services","items"=>array(
			array("ename"=>"leavewords","show"=>false,"cname"=>"Message Management","items"=>array(
				array("cname"=>"User Comments","url"=>"service.php?action=list"),
			)),
			array("ename"=>"helps","cname"=>"Web Assistant","items"=>array(
				array("cname"=>"Help Category","url"=>"helptype.php?action=list"),
				array("cname"=>"Add Category","url"=>"helptype.php?action=mod"),
				array("cname"=>"Help File","url"=>"help.php?action=list"),
				array("cname"=>"Adding Help","url"=>"help.php?action=mod"),
			)),
		)),
6=>array(
		"ename"=>"templets","url"=>"templet.php?action=list","cname"=>"Templates","items"=>array(
			array("ename"=>"company_templets","show"=>false,"cname"=>"Enterprise Templates","items"=>array(
				array("cname"=>"Member Home Templates","url"=>"templet.php?action=list"),
				array("cname"=>"Add Member Home Templates","url"=>"templet.php?action=mod"),
			)),
		)),
7=>array(
		"ename"=>"links","url"=>"friendlink.php?action=list","cname"=>"Other","items"=>array(
			array("ename"=>"membership_links","cname"=>"Link","items"=>array(
				array("cname"=>"Link Management","url"=>"friendlink.php?action=list"),
				array("cname"=>"Add Link","url"=>"friendlink.php?action=mod"),
			)),
			array("ename"=>"userpages","cname"=>"Custom Page","items"=>array(
				array("cname"=>"Write Page","url"=>"userpage.php?action=mod"),
				array("cname"=>"Page Management","url"=>"userpage.php?action=list"),
			)),
			array("ename"=>"staticset","cname"=>"Static Cache","items"=>array(
				array("cname"=>"Static document management","url"=>"mkstatic.php?action=staticfiles"),
				array("cname"=>"Clear build file","url"=>"mkstatic.php?action=clearcompile"),
			)),
			array("ename"=>"industry","cname"=>"Sectors","items"=>array(
				array("cname"=>"Category Management","url"=>"industry.php?action=list"),
				array("cname"=>"Updated industry data","url"=>"industry.php?action=update"),

				array("cname"=>"Add Sectors","url"=>"industry.php?action=mod"),
				array("cname"=>"Generating industry, the drop-down data","url"=>"industry.php?action=industryxml"),

				array("cname"=>"Provinces and cities in the drop-down data is generated","url"=>"industry.php?action=areaxml"),
			)),
			array("ename"=>"area","cname"=>"District Management","items"=>array(
				array("cname"=>"Area List","url"=>"area.php?action=list"),
				array("cname"=>"Provinces and cities in the drop-down data is generated","url"=>"industry.php?action=areaxml"),
				array("cname"=>"Update the cache region","url"=>"area.php?action=update"),
			)),
			array("ename"=>"announce","cname"=>"Announcement Management<img src=\"images/new2.gif\" border=0 />","items"=>array(
				array("cname"=>"Announcement List","url"=>"announce.php?action=list"),
				array("cname"=>"New Announcement","url"=>"announce.php?action=mod"),
			)),
			array("ename"=>"adminer","cname"=>"Administrator","items"=>array(
				array("cname"=>"Manager List","url"=>"adminer.php"),
				array("cname"=>"Change Password","url"=>"adminer.php?action=password"),
			)),
		)),
);

?>