<!--// Created Dec 22, 2009, 14:12 -->
var data_industry = { 
'0':{"1":"\u6570\u5b57\u5a31\u4e50\r","2":"\u865a\u62df","3":"\u6570\u7801\r","4":"\u62a4\u80a4\r","5":"\u670d\u9970\r","6":"\u5bb6\u5c45\r","7":"\u6587\u4f53\r","8":"\u6536\u85cf\r","9":"\u5176\u4ed6"},
'0,1':{"10":"\u6570\u5b57\u89c6\u9891\/\u9ad8\u6e05\u5728\u7ebf\r","11":"\u70ed\u95e8\u7535\u5f71\/\u6700\u65b0\u5927\u7247\r","12":"\u8fde\u64ad\u5267\u573a\/\u62a2\u5148\u89c2\u770b\r","13":"\u5973\u6027\u6742\u5fd7\r","14":"\u89c6\u89c9\u76db\u5bb4\r","15":"\u98ce\u5c1a\u5148\u751f\/\u8d44\u8baf\u6742\u5fd7\r","16":"\u5a31\u4e50\u6742\u5fd7\r","17":"\u65f6\u5c1a\u751f\u6d3b "},
'0,1,10':{"18":"\u70ed\u95e8\r","19":"\u65b0\u7247\r","20":"\u7ecf\u5178\r","21":"\u6392\u884c\u699c\r"},
'0,1,11':{"23":"\u52a8\u4f5c\u7247\r","24":"\u7206\u7b11\u7247\r","25":"\u7231\u60c5\r","26":"\u52a8\u753b\r","27":"\u5acc\u7591\r","28":"\u5076\u50cf\r","29":"\u4f26\u7406\r","30":"\u90fd\u5e02\r","31":"\u8a00\u60c5"},
'0,1,12':{"32":"\u6e2f\u53f0\r","33":"\u65e5\u97e9\r","34":"\u6b27\u7f8e\r","36":"\u5185\u5730\r","37":"\u5267\u60c5"},
'0,1,13':{"38":"\u5973\u6027\r","39":"\u65f6\u5c1a\r","40":"\u4f11\u95f2\r","41":"\u5a31\u4e50\r","42":"\u7f8e\u5bb9\r","43":"\u5065\u5eb7\u4fdd\u517b","49":"\u80b2\u513f"},
'0,1,14':{"44":"\u65f6\u5c1a\u5927\u5178\r","45":"\u8d2d\u7269\r","46":"\u51cf\u80a5\r","47":"\u670d\u9970\r","48":"\u88c5\u9970\u88c5\u6f62"},
'0,1,15':{"50":"\u7535\u8111\r","51":"\u7ecf\u6d4e\r","52":"\u91d1\u878d\r","53":"\u6e38\u620f\r","54":"\u7537\u4eba\r"},
'0,1,16':{"56":"\u660e\u661f\r","57":"\u7535\u5f71\r","58":"\u7f8e\u5973\r","59":"\u5a31\u4e50\r","60":"\u804c\u573a"},
'0,1,17':{"61":"\u65f6\u5c1a"},
'0,2':{"62":"\u79fb\u52a8\/\u8054\u901a\/\u7535\u4fe1\u5145\u503c\u5361\r","63":"\u7f51\u6e38\u865a\u62df\u7269\u54c1\u4ea4\u6613\u533a\r","64":"\u5f69\u7968\/\u5927\u4e50\u900f\/\u4e03\u661f\u5f69\/\u6392\u5217\u4e09\r","65":"\u6298\u6263\u533a","374":"\u4e34\u65f61","375":"\u4e34\u65f62","376":"\u4e34\u65f63"},
'0,2,62':{"66":"\u79fb\u52a8\r","67":"\u8054\u901a\r","68":"\u7535\u4fe1\r","69":"IP\u5361\r","70":"IC\u5361\r","71":"\u5145\u503c\u5361\r","72":"100\r","73":"50\r","74":"skype"},
'0,2,63':{"75":"\u9b54\u517d\r","76":"\u68a6\u5e7b\r","77":"\u8700\u95e8\r","78":"DNF\r","79":"QQ\u5e01\r","80":"\u6e38\u620f\u5e01\r","81":"\u52b2\u821e\u56e2"},
'0,2,64':{"82":"\u53cc\u8272\u7403\r","83":"\u8d85\u7ea7\u5927\u4e50\u900f\r","84":"3D\r","85":"\u4e03\u661f\u5f69\r","86":"\u4e03\u4e50\u5f69\r","87":"\u6392\u5217\u4e09\r","88":"\u798f\u5f69\r","89":"\u4f53\u5f69"},
'0,2,65':{"90":"\u9152\u5e97\r","91":"\u673a\u7968\r","92":"\u706b\u8f66\u7968\r","93":"\u5ba2\u6808\r","94":"\u65c5\u6e38\u8def\u7ebf\r","95":"\u666f\u533a\u95e8\u7968"},
'0,3':{"96":"\u624b\u673a\/NOKIA\/\u4e09\u661f\/MOTO\r","97":"\u7b14\u8bb0\u672c\/ThinkPad\/DELL\r","98":"\u7535\u8111\u786c\u4ef6\/LCD\/\u53f0\u5f0f\u6574\u673a\/\u7f51\u7edc\r","99":"\u6570\u7801\u76f8\u673a\/\u6444\u50cf\u673a\/\u6444\u5f71\u5668\u6750\r","100":"MP3\/MP4\/MP5\/iPod\/\u5f55\u97f3\u7b14\r","101":"\u95ea\u5b58\/U\u76d8\/\u8bb0\u5fc6\u68d2\/\u79fb\u52a8\u5b58\u50a8\r","102":"\u624b\u673a\u914d\u4ef6\/\u76f8\u673a\u914d\u4ef6\/\u6570\u7801\u914d\u4ef6\r","103":"\u529e\u516c\u8bbe\u5907\/\u6587\u5177\/\u8017\u6750\r","131":"\u5bb6\u7535\/HiFi\u97f3\u7bb1\/\u53d6\u6696\/\u52a0\u6e7f\/\u70df\u7076"},
'0,3,96':{"105":"\u56fd\u8d27\r","106":"iPhone\r","107":"LG\r","108":"\u7d22\u7231\r","109":"\u591a\u666e\u8fbe\r","110":"\u8bfa\u57fa\u4e9a\r","111":"\u4e09\u661f\r","112":"MOTO\r","113":"\u5c71\u5be8"},
'0,3,97':{"114":"\u4e0a\u7f51\u672c\r","115":"IBM\r","116":"\u82f9\u679c\r","117":"\u8054\u60f3\r","118":"HP\r","119":"\u4e8c\u624b\r","120":"\u6234\u5c14\r","121":"\u6e05\u534e\u540c\u65b9\r","122":"\u65b9\u6b63 "},
'0,3,98':{"123":"LED\r","124":"LCD\r","125":"\u4e3b\u677f\r","126":"\u663e\u5361\r","127":"\u5185\u5b58\u6761\r","128":"CPU\r","129":"\u786c\u76d8\r","130":"\u4e0a\u7f51\u5361"},
'0,3,99':{"132":"\u7d22\u5c3c\r","133":"\u4f73\u80fd\r","134":"LOMO\r","135":"\u4e09\u661f\r","136":"\u677e\u4e0b\r","137":"\u5c3c\u5eb7"},
'0,3,100':{"166":"iPod\r","167":"\u84dd\u9b54\r","168":"\u6602\u8fbe\r","169":"\u7d22\u5c3c\r","170":"\u827e\u8bfa\r","171":"\u7535\u73a9"},
'0,3,101':{"158":"U\u76d8\r","159":"\u5185\u5b58\u5361\r","160":"SD\u5361\r","161":"4G\r","162":"8G\r","163":"16G\r","164":"\u8bb0\u5fc6\u68d2\r","165":"\u79fb\u52a8\u786c\u76d8"},
'0,3,102':{"149":"3G\u4e0a\u7f51\r","150":"\u7535\u6c60\r","151":"\u4fdd\u6696\r","152":"\u6444\u50cf\u5934\r","153":"\u84dd\u7259\r","154":"\u9f20\u6807\u57ab\r","155":"\u9f20\u6807\r","156":"SD\u5361\r","157":"","172":"3G\u4e0a\u7f51\r","173":"\u7535\u6c60\r","174":"\u4fdd\u6696\r","175":"\u6444\u50cf\u5934\r","176":"\u84dd\u7259"},
'0,3,103':{"144":"\u6295\u5f71\u4eea\r","145":"\u6253\u5370\u673a\r","146":"\u6587\u5177\r","147":"\u7535\u5b50\u8f9e\u5178\r","148":"\u58a8\u76d2"},
'0,3,131':{"138":"\u6db2\u6676\u663e\u793a\u5668\r","139":"\u8033\u673a\r","140":"\u9505\u7172\r","141":"\u8c46\u6d46\u673a\r","142":"\u6cb9\u6c40\r","143":"\u6d17\u8863\u673a"},
'0,4':{"177":"\u7f8e\u5bb9\u62a4\u80a4\/\u7f8e\u4f53\/\u7cbe\u6cb9\r","178":"\u5f69\u5986\/\u9999\u6c34\/\u7f8e\u53d1\/\u5de5\u5177\r","179":"\u4e2a\u4eba\u62a4\u7406\/\u4fdd\u5065\/\u7f8e\u5bb9\/\u98de\u5229\u6d66"},
'0,4,177':{"180":"\u723d\u80a4\u6c34\r","181":"\u7cbe\u534e\u6db2\r","182":"\u9762\u819c\r","183":"\u9694\u79bb\u971c\r","184":"\u7cbe\u6cb9"},
'0,4,178':{"185":"\u9999\u6c34\r","186":"\u7c89\u997c\r","187":"\u7c89\u5e95\r","188":"\u773c\u5f71\r","189":"\u816e\u7ea2\r","190":"BB\u971c"},
'0,4,179':{"191":"\u7535\u5439\u98ce\r","192":"\u8db3\u6d74\u76c6\r","193":"\u6696\u819d\r","194":"\u5243\u987b\r","195":"\u6309\u6469"},
'0,5':{"196":"\u7cbe\u54c1\u5973\u88c5\/\u97e9\u7248\/\u7fbd\u7ed2\u670d\/\u5916\u5957\r","197":"\u5973\u978b\/\u9774\u5b50\/\u76ae\u9774\/Ugg\/\u7396\u7199\r","198":"\u7537\u5973\u5185\u8863\/\u7761\u8863\/\u9edb\u5b89\u82ac\/\u732b\u4eba\r","199":"\u7537\u88c5\/\u68c9\u8863\/\u7fbd\u7ed2\u670d\/\u5fa1\u5bd2\u670d\r","200":"\u5973\u5305\/\u7537\u5305\/\u94b1\u5305\/\u76ae\u5305\/\u5361\u5305\r","201":"\u56f4\u5dfe\/\u5e3d\u5b50\/\u4fdd\u6696\u5957\u4ef6\/\u8170\u5e26\r","202":"\u8fd0\u52a8\u670d\/\u7fbd\u7ed2\u670d\/\u8fd0\u52a8\u5957\u88c5\r","203":"\u8fd0\u52a8\u978b\/Nike\/Adidas\/\u674e\u5b81\r","204":"\u7ae5\u88c5\/\u7ae5\u978b\/\u54c8\u8863\/\u5b55\u5987\u88c5\r","205":"\u624b\u8868\/\u897f\u94c1\u57ce\/\u96f7\u8fbe\/Swatch\r","206":"\u65f6\u5c1a\u9970\u54c1\/\u6d41\u884c\u9970\u54c1\/\u97e9\u7248\r","207":"\u73e0\u5b9d\/\u94bb\u77f3\/\u7fe1\u7fe0\/\u9ec4\u91d1\/\u5468\u751f\u751f"},
'0,5,196':{"370":"\u5973\u88c55\u6298\r","371":"\u6bdb\u8863\r","372":"\u5462\u5927\u8863\r","373":"\u68c9\u8863"},
'0,5,197':{"365":"\u9774\u5b50\r","366":"\u77ed\u9774\r","367":"\u96ea\u5730\u9774\r","368":"\u957f\u9774\r","369":"\u7537\u978b"},
'0,5,198':{"359":"\u6587\u80f8\r","360":"\u7761\u8863\r","361":"\u4fdd\u6696\r","362":"\u88e4\u889c\r","363":"\u5851\u8eab\r","364":"\u5185\u88e4"},
'0,5,199':{"354":"\u7fbd\u7ed2\u670d\r","355":"\u68c9\u8863\r","356":"\u98ce\u8863\r","357":"\u6bdb\u8863\r","358":"\u725b\u4ed4\u88e4"},
'0,5,200':{"349":"\u80a9\u5305\r","350":"\u624b\u63d0\u5305\r","351":"\u659c\u630e\u5305\r","352":"\u94b1\u5305\r","353":"\u725b\u76ae\u5305"},
'0,5,201':{"344":"\u56f4\u5dfe\r","345":"\u5e3d\u5b50\r","346":"\u6bdb\u7ebf\u56f4\u5dfe\r","347":"\u6bdb\u7ebf\u5e3d\r","348":"\u76ae\u5e26"},
'0,5,202':{"339":"\u8fd0\u52a8\u5957\u88c5\r","340":"\u68c9\u8863\r","341":"\u536b\u8863\r","342":"\u8010\u514b\r","343":"\u674e\u5b81"},
'0,5,203':{"334":"\u8dd1\u6b65\u978b\r","335":"\u7bee\u7403\u978b\r","336":"\u8db3\u7403\u978b\r","337":"\u677f\u978b\r","338":"\u5e06\u5e03"},
'0,5,204':{"328":"\u68c9\u670d\r","329":"\u6bdb\u8863\r","330":"\u7ae5\u88e4\r","331":"\u5916\u5957\r","332":"\u51ac\u9774\r","333":"\u7fbd\u7ed2"},
'0,5,205':{"323":"\u5929\u68ad\r","324":"\u5361\u897f\u6b27\r","325":"\u6b27\u7c73\u8304\r","326":"\u6d6a\u7434\r","327":"\u52b3\u529b\u58eb"},
'0,5,206':{"318":"\u6bdb\u8863\u94fe\r","319":"\u8033\u73af\r","320":"\u53d1\u9970\r","321":"\u6212\u6307\r","322":"\u94f6\u9970"},
'0,5,207':{"313":"\u5a5a\u94bb\r","314":"\u7fe1\u7fe0\r","315":"\u65bd\u534e\u6d1b\r","316":"\u5343\u8db3\u91d1\r","317":"\u5468\u5927\u798f"},
'0,6':{"208":"\u5c45\u5bb6\u65e5\u7528\/\u53a8\u623f\u9910\u996e\/\u536b\u6d74\u6d17\u6d74\r","209":"\u5e8a\u4e0a\u7528\u54c1\/\u9760\u57ab\/\u7a97\u5e18\/\u5e03\u827a\r","210":"\u5bb6\u5177\/\u5bb6\u5177\u5b9a\u5236\/\u5b9c\u5bb6\u4ee3\u8d2d\r","211":"\u5976\u7c89\/\u5c3f\u7247\/\u6bcd\u5a74\u7528\u54c1\r","212":"\u76ca\u667a\u73a9\u5177\/\u65e9\u6559\/\u7ae5\u8f66\u5e8a\/\u51fa\u884c"},
'0,6,208':{"307":"\u6536\u7eb3\r","308":"\u676f\r","309":"\u7279\u4ef7\u533a\r","310":"\u5a5a\u5e86\r","311":"\u9910\u5177\r","312":"\u4fdd\u6696"},
'0,6,209':{"302":"\u51ac\u88ab\r","303":"\u56db\u4ef6\u5957\r","304":"\u9760\u57ab\r","305":"\u6bef\u5b50\r","306":"\u5c45\u5bb6\u978b"},
'0,6,210':{"296":"\u5e8a\r","297":"\u5b9c\u5bb6\r","298":"\u8863\u67dc\r","299":"\u6c99\u53d1\r","300":"\u7535\u8111\u684c\r","301":"\u67b6\u7c7b"},
'0,6,211':{"291":"\u5976\u7c89\r","292":"\u8f85\u98df\r","293":"\u8425\u517b\u54c1\r","294":"\u7761\u888b\r","295":"\u7eb8\u5c3f\u88e4"},
'0,6,212':{"285":"\u76ca\u667a\r","286":"\u7ae5\u8f66\r","287":"\u63a8\u8f66\r","288":"\u7ae5\u5e8a\r","289":"\u9910\u6905\r","290":"\u65e9\u6559"},
'0,7':{"213":"\u8fd0\u52a8\/\u821e\u8e48\/\u5065\u8eab\/\u7fbd\u6bdb\u7403\r","214":"\u4e66\u7c4d\/\u8ba1\u7b97\u673a\/\u7ecf\u7ba1\/\u6587\u827a\r","215":"\u4e50\u5668\/\u97f3\u4e50\/\u5f71\u89c6\/\u660e\u661f\/\u52a8\u753b\u7247\r","216":"\u6237\u5916\/\u767b\u5c71\/\u91ce\u8425\/\u65c5\u884c\u88c5\u5907\r","217":"\u9c9c\u82b1\u901f\u9012\/\u5ba0\u7269\u98df\u54c1\/\u7528\u54c1\r","218":"Zippo\/\u773c\u955c\/\u62a4\u773c\/\u519b\u5200\/\u70df\u5177"},
'0,7,213':{"280":"\u7fbd\u62cd\r","281":"\u6e29\u6cc9\r","282":"\u8df3\u821e\u6bef\r","283":"\u4e52\u4e53\r","284":"\u8dd1\u6b65\u673a"},
'0,7,214':{"274":"\u8003\u8bd5\r","275":"\u5c0f\u8bf4\r","276":"\u7ae5\u4e66\r","277":"\u5916\u8bed\r","278":"\u6f2b\u753b\r","279":"\u517b\u751f"},
'0,7,215':{"269":"\u7535\u5f71\r","270":"\u7535\u89c6\u5267\r","271":"\u5409\u4ed6\r","272":"\u97f3\u4e50\r","273":"\u513f\u7ae5\u97f3\u50cf"},
'0,7,216':{"264":"\u767b\u5c71\u978b\r","265":"\u51b2\u950b\u8863\r","266":"\u6293\u7ed2\u8863\r","267":"\u7761\u888b\r","268":"\u6ed1\u96ea"},
'0,7,217':{"258":"\u72d7\u7cae\r","259":"\u96f6\u98df\r","260":"\u732b\u7cae\r","261":"\u6c34\u65cf\r","262":"\u9c9c\u82b1\r","263":"\u56ed\u827a"},
'0,7,218':{"253":"zippo\r","254":"\u592a\u9633\u955c\r","255":"\u773c\u955c\u67b6\r","256":"\u70df\u5634\r","257":"\u6212\u70df"},
'0,8':{"219":"\u53e4\u8463\/\u90ae\u5e01\/\u5b57\u753b\/\u6536\u85cf\r","220":"\u73a9\u5177\/\u6a21\u578b\/\u5a03\u5a03\/\u4eba\u5076\r","221":"\u65f6\u5c1a\u5bb6\u9970\/\u5de5\u827a\u54c1\/\u5341\u5b57\u7ee3"},
'0,8,219':{"248":"\u94b1\u5e01\r","249":"\u7d2b\u7802\r","250":"\u548c\u7530\u7389\r","251":"\u5b97\u6559\r","252":"\u53e4\u73a9\u8857"},
'0,8,220':{"238":"\u6bdb\u7ed2\r","239":"\u73a9\u5177\r","240":"\u673a\u5668\u4eba\r","241":"\u5a03\u5a03\r","242":"\u6a21\u578b","243":"\u6bdb\u7ed2\r","244":"\u73a9\u5177\r","245":"\u673a\u5668\u4eba\r","246":"\u5a03\u5a03\r","247":"\u6a21\u578b"},
'0,8,221':{"233":"\u5de5\u827a\u6446\u8bbe\r","234":"\u5899\u8d34\r","235":"\u5341\u5b57\u7ee3\r","236":"\u88c5\u9970\r","237":"\u753b\u949f"},
'0,9':{"222":"\u7f51\u5e97\/\u7f51\u7edc\u670d\u52a1\/\u4e2a\u6027\u5b9a\u5236\/\u8f6f\u4ef6\r","223":"\u6298\u6263\u5238\/\u6f14\u5531\u4f1a\/\u65c5\u6e38\/\u5403\u559d\u73a9\u4e50"},
'0,9,222':{"224":"\u7f51\u7edc\u670d\u52a1\r","225":"\u8f6f\u4ef6\r","226":"\u6444\u5f71\r","227":"\u7f51\u5e97\r","228":"\u8dd1\u817f"},
'0,9,223':{"229":"\u8d85\u5e02\u5361\r","230":"\u86cb\u7cd5\u5238\r","231":"\u7535\u5f71\u7968\r","232":"\u4f53\u68c0\u5361"}
}