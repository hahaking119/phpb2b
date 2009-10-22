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
				array("cname"=>"Registration","url"=>"setting.php?action=permission"),
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
				array("cname"=>"Management","url"=>"trade.php?action=list"),
				array("cname"=>"Add Lead","url"=>"trade.php?action=mod"),
				array("cname"=>"Statistics(Beta)","url"=>"trade.php?action=stat"),
			)),
			array("ename"=>"product","cname"=>"Products","items"=>array(
				array("cname"=>"Management","url"=>"product.php?action=list"),
				array("cname"=>"Add Product","url"=>"product.php?action=mod"),

			)),
			array("ename"=>"company","cname"=>"Company","items"=>array(
				array("cname"=>"Management","url"=>"company.php?action=list"),
				array("cname"=>"Add Company","url"=>"company.php?action=mod"),
				array("cname"=>"Company Type","url"=>"companytype.php?action=list"),
				array("cname"=>"Add type","url"=>"companytype.php?action=mod"),
				array("cname"=>"Company Video","url"=>"company.php?action=vcr"),
			)),
			array("ename"=>"market","cname"=>"Markets","items"=>array(
				array("cname"=>"Management","url"=>"market.php?action=list"),
				array("cname"=>"Add Market","url"=>"market.php?action=mod"),
			)),
			array("ename"=>"job","cname"=>"Jobs","items"=>array(
				array("cname"=>"Management","url"=>"job.php?action=list"),
			)),
			array("ename"=>"member","cname"=>"Member Center","items"=>array(
				array("cname"=>"Member","url"=>"member.php?action=list"),
				array("cname"=>"Add Member","url"=>"member.php?action=mod"),
				array("cname"=>"MemberType","url"=>"membertype.php?action=list"),
				array("cname"=>"Add type","url"=>"membertype.php?action=mod")
			)),
			array("ename"=>"member","cname"=>"Exhibition","items"=>array(
				array("cname"=>"Management","url"=>"fair.php?action=list"),
				array("cname"=>"Type Manager","url"=>"fairtype.php?action=list"),
				array("cname"=>"Add Expo","url"=>"fair.php?action=mod"),
				array("cname"=>"Add Type","url"=>"fairtype.php?action=mod")
			)),
			array("ename"=>"order","cname"=>"Orders","items"=>array(
				array("cname"=>"Management","url"=>"order.php?action=list")
			)),
			array("ename"=>"keyword","cname"=>"keyword","items"=>array(
				array("cname"=>"List","url"=>"keyword.php?action=list"),
				array("cname"=>"bidding","url"=>"keywordship.php?action=list"),
				array("cname"=>"Add auction","url"=>"keywordship.php?action=mod")
			)),
)),
3=>array(
		"ename"=>"ads","url"=>"ad.php?action=list","cname"=>"Ads","items"=>array(
			array("ename"=>"ads","show"=>false,"cname"=>"Ad Position","items"=>array(
				array("cname"=>"Position","url"=>"adzone.php?action=list"),
				array("cname"=>"Add","url"=>"adzone.php?action=mod"),
			)),
			array("ename"=>"ads","show"=>false,"cname"=>"Advertising","items"=>array(
				array("cname"=>"Listing","url"=>"ad.php?action=list"),
				array("cname"=>"Add","url"=>"ad.php?action=mod"),
			)),
		)),
4=>array(
		"ename"=>"news","url"=>"news.php?action=list","cname"=>"News","items"=>array(
			array("ename"=>"news","show"=>false,"cname"=>"News","items"=>array(
				array("cname"=>"All news","url"=>"news.php?action=list"),
				array("cname"=>"Add","url"=>"news.php?action=mod"),
			)),
			array("ename"=>"newstypes","cname"=>"Type","items"=>array(
				array("cname"=>"Information Type","url"=>"newstype.php?action=list"),
				array("cname"=>"Add Category","url"=>"newstype.php?action=mod"),
			)),
			array("ename"=>"companynews","cname"=>"News","items"=>array(
				array("cname"=>"Management","url"=>"companynews.php?action=list"),
			)),
			array("ename"=>"companymessages","cname"=>"Business review","items"=>array(
				array("cname"=>"Comment","url"=>"companymessage.php?action=list"),
			)),
	)),
5=>array(
		"ename"=>"services","url"=>"service.php?action=list","cname"=>"Online Services","items"=>array(
			array("ename"=>"leavewords","show"=>false,"cname"=>"Management","items"=>array(
				array("cname"=>"Comments","url"=>"service.php?action=list"),
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
			array("ename"=>"company_templets","show"=>false,"cname"=>"Templates","items"=>array(
				array("cname"=>"Management","url"=>"templet.php?action=list"),
				array("cname"=>"Add Template","url"=>"templet.php?action=mod"),
			)),
		)),
7=>array(
		"ename"=>"links","url"=>"friendlink.php?action=list","cname"=>"Other","items"=>array(
			array("ename"=>"membership_links","cname"=>"Link","items"=>array(
				array("cname"=>"Management","url"=>"friendlink.php?action=list"),
				array("cname"=>"Add Link","url"=>"friendlink.php?action=mod"),
			)),
			array("ename"=>"userpages","cname"=>"Custom Page","items"=>array(
				array("cname"=>"Write New","url"=>"userpage.php?action=mod"),
				array("cname"=>"Management","url"=>"userpage.php?action=list"),
			)),
			array("ename"=>"staticset","cname"=>"Static Cache","items"=>array(
				array("cname"=>"Management","url"=>"mkstatic.php?action=staticfiles"),
				array("cname"=>"Clear","url"=>"mkstatic.php?action=clearcompile"),
			)),
			array("ename"=>"industry","cname"=>"Sectors","items"=>array(
				array("cname"=>"Categories","url"=>"industry.php?action=list"),
				array("cname"=>"Updated data","url"=>"industry.php?action=update"),

				array("cname"=>"Add Sector","url"=>"industry.php?action=mod"),
				array("cname"=>"Generating","url"=>"industry.php?action=industryxml"),

				array("cname"=>"Regenerate","url"=>"industry.php?action=areaxml"),
			)),
			array("ename"=>"area","cname"=>"District","items"=>array(
				array("cname"=>"List","url"=>"area.php?action=list"),
				array("cname"=>"Renerate","url"=>"industry.php?action=areaxml"),
				array("cname"=>"Update region","url"=>"area.php?action=update"),
			)),
			array("ename"=>"announce","cname"=>"Announce<img src=\"images/new2.gif\" border=0 />","items"=>array(
				array("cname"=>"List","url"=>"announce.php?action=list"),
				array("cname"=>"Add New","url"=>"announce.php?action=mod"),
			)),
			array("ename"=>"adminer","cname"=>"Administrator","items"=>array(
				array("cname"=>"List","url"=>"adminer.php"),
				array("cname"=>"Change Password","url"=>"adminer.php?action=password"),
			)),
		)),
);

?>