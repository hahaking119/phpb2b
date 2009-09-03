/* JavaScript Document */

/*

xmlTree v1.2
=================================

Infomation
----------------------
Author   : Lapuasi
E-Mail   : lapuasi@gmail.com
WebSite  : http://www.lapuasi.com/javascript
DateTime : 2005-12-25


Example
----------------------
var tree = new xmlTree('tree'); //生成对象
tree.typeid = 1; //设置初始模式，默认全部关闭。0全部关闭，1全部展开
tree.createTree(); //输出树

@params typeid:
1:表示统计求购
2:表示统计供应
3:表示统计公司库
4:表示统计产品库
@params mode:
for Internet Explorer, Mozilla Firefox
*/


function xmlTree(name,xmlfile,typeid) {
	this.use_static_html = false;
	this.name         = name;                   //实例名称
	if(xmlfile == null)
	this.xmlFile      = './media/xml/industry_list.xml'; //默认xml文件
	else this.xmlFile = xmlfile;
	this.mode = 1;//展现模式 ,1一排显示两行,2只显示一长列
	this.typeid         = typeid;           //初始模式，默认全部关闭。0全部关闭，1全部展开
	this.html         = '';                     //最终输出html代码
	this.prevTip      = null;                   //上一次被显示的tip的时间编号 (内部使用)
	this.prevSelected = null;                   //上一次被选中的节点的自动编号 (内部使用)
}

xmlTree.prototype.createXMLDOM = function() { //生成XMLDOM对象
	var xmldom;
	if (window.ActiveXObject){
		var xmldom = new ActiveXObject("Microsoft.XMLDOM");
	} else {
		if (document.implementation && document.implementation.createDocument) {
			var xmldom = document.implementation.createDocument("","doc",null);
		}
	}
	xmldom.async = false;
	xmldom.resolveExternals = false;
	xmldom.validateOnParse = false;
	xmldom.preserveWhiteSpace = true;
	return xmldom;
}

xmlTree.prototype.createTree = function() { //生成并打印
	var xmldom = this.createXMLDOM();
	document.write('<div id="tree"><\/div>'); // 树所用层
	if (xmldom.load(this.xmlFile)) {
		this.createNodes(xmldom);
	} else {
		this.html = 'Load XML Error';
	}
	document.getElementById('tree').innerHTML = this.html;
	return;
}

xmlTree.prototype.getFirstChildData = function(obj, name) { //取得指定名称节点的第一个子节点的数据
	var result = '';
	if (typeof(obj) == 'object' && name != null && name != '') {
		var node = obj.getElementsByTagName(name);
		if (node != null && node.length > 0) {
			result = node[0].firstChild.data;
		}
	}
	return result;
}

xmlTree.prototype.checkChildNodes = function(obj, id) { //检测是否有分支
	var result = false;
	var nodes = obj.getElementsByTagName('node');
	if (nodes != null && nodes.length > 0) {
		//var pid;
		for (var i = 0; i < nodes.length; i++) {
			//pid = nodes[i].getAttribute('parentid');
			if (nodes[i].getAttribute('parentid') == id) {
				result = true;
				break;
			}
		}
	}
	return result;
}

xmlTree.prototype.createNodes = function(obj, id) { //生成指定编号节点的树
	if (typeof(id) == 'undefined') id = null; //如果没有id传入则为根节点
	var nodes = obj.getElementsByTagName('node');
	if (nodes != null && nodes.length > 0) {
		//var modeClass, modeSrc, iconClass, iconSrc;
		var nid, npid, nname, nicon, nlink, ntarget, nexplain, hasChildNodes;
		var amount;
		var xmlWidth=188;
		switch ((this.typeid))
		{
			case 1:counttype='buy';break;
			case 2:counttype='sell';break;
			case 3:counttype='company';break;
			case 4:counttype='product';break;
			case 5:counttype='news';break;
			default:counttype='buy';break;
		}
		//判断模式类型，并应用样式
		if (id == null) modeClass = 'open'; //若为根节点则显示
		//this.html += '<ul id="tree_' + id + '_c" class="' + modeClass + '">';
		this.html += '<table width='+xmlWidth+' border=0><tr>';
		var pcount = nodes.length;
		var currentp = 0;//当前类
		for (var i = 0; i<pcount; i++) {
			npid = nodes[i].getAttribute('parentid');
			amount = nodes[i].getAttribute(counttype+'_amount');
			if (npid == id) {
				//初始化
				currentp++;

				//取得节点编号并检测
				nid = nodes[i].getAttribute('id');
				//this.html += '<li id="tree_' + nid + '"><span>';
				
				//取得节点自定义图标
				//判断是否含有子节点，并确定箭头和图标的图片及样式
				hasChildNodes = this.checkChildNodes(obj, nid);

				/**
				 * 静态页面时处理
				 */
				if(this.static_html_level>0){
					nlink = '../htmls/'+counttype+'/list/'+nid+'/'+nid+'_1.html';
				}else{
					//取得节点连接
					nlink = './list.php?sid='+nid;
				}
				if (nlink != '') {
					nlink = ' href="' + nlink + '"';
				} else {
					nlink = ' href="javascript:;"';
				}

				//取得节点名称
				nname = this.getFirstChildData(nodes[i], 'name');
				if(npid ==null){
					this.html += '<td width=100% align="left"><img alt="" src="/images/dot2.gif" width="3" height="5"></td><td><a class="font14blak" id="tree_' + nid + '_l"' + nlink  + ' title="'+ nname + '">' + nname  + '</a><span class="time">' + '(' + amount + ')</span>';
				}else{
					this.html += '<a id="tree_' + nid + '_l"' + nlink + ' title="'+ nname + '">'  + nname + '</a>' + '|';
				}
				//this.html+=i;
				//this.html += '<a id="tree_' + nid + '_l"' + nlink  + '>' + nname +'<\/a>' + '(' + amount + ')<\/span>';
				if (hasChildNodes) {
					//this.htm += '</tr><tr>';
					this.html += '<br>';
					this.createNodes(obj, nid); //迭代子节点
					this.html += '</td>';
					if(this.mode==1){
						if (currentp%2==0)
						{
							this.html += '</tr>';
						}
					}else{
							this.html += '</tr>';
					}
				}else{
					if(npid==null){
						this.html += '</td>';
						if(this.mode==1){
							if (currentp%2==0)
							{
								this.html += '</tr>';
							}
						}else{
								this.html += '</tr>';
						}
					}
				}
			}
		if(i==pcount-1) this.html += '</table>';
		}
	}
	return;
}