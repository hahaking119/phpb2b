/*
 * 
 * 
 * Licensed under the terms of the GNU Lesser General Public License:
 * 		http://www.opensource.org/licenses/lgpl-license.php
 * 
 * File Name: linkage.js
 * 
 * Version:  1.1
 * Modified: 2006-7-20 15:31:48
 * 
 * File Authors:
 * 		张亚楠 (zhangyanan2008@gmail.com)
 *
 * Thanks To:
 *		HopeSoftStudio (http://www.10090.com)
 *
 * Online Demo & Download:
 *		http://www.wofeila.com/test/menu/menu.htm
 *		http://www.wofeila.com/test/menu/menu.rar
 */


var Linkage = Class.create();
Linkage.prototype = {
	initialize : function(dataSrc, xmlFile) {
		this.dataSrc = dataSrc;
		this.xmlFile = xmlFile;
	},

	dataSrc : "" ,
	xmlFile : "" ,
	
	//初始化SELECT列表时的默认值
	BLANK_SELECT : "-----请选择-----" ,

	//三维数组 总的数据数组
	AllMenuArr : new Array() ,

	//二维数组 应用的表单(SELECT)元素数组
	MenuIdArr : new Array() ,

	//各分支数据级组
	MenuInfoArr : new Array() ,

	//遍历XML时，记录当前元素深度
	iDepth : -1 ,

	tree : function(dataSrc, Element) {
		var node = "";
		if(Element.nodeType != 3) {
			node = Element;
			this.onElement(dataSrc, Element);
		}
		if(Element.hasChildNodes) {
			for(var i=0;i<Element.childNodes.length;i++) {
				if (Element.childNodes[i].nodeType != 3) {
					this.iDepth++;
					this.tree(dataSrc, Element.childNodes[i]);
				}
			}
		}
		if(node) {
			this.endElement();
		}
	} ,

	onElement : function(dataSrc, ele) {
		if ($V(ele, "Value") != null) {
			if (this.MenuInfoArr[dataSrc] == null) {
				this.MenuInfoArr[dataSrc] = new Array();
			}
			if (this.MenuInfoArr[dataSrc][this.iDepth] == null) {
				this.MenuInfoArr[dataSrc][this.iDepth] = new Array();
			}
			this.MenuInfoArr[dataSrc][this.iDepth].push(new MenuInfo($V(ele.parentNode, "Value") , $V(ele, "Value") , ($V(ele, "Desc")==null ? $V(ele, "Value") : $V(ele, "Desc"))));
		}
	} ,

	endElement : function() {
		this.iDepth--;
	} ,

	//初始化空的SELECT
	initBlank : function(element) {
		element.length = 0;
		element.options.add(new Option( this.BLANK_SELECT, "" ));
		element.selectedIndex = 0;
	} ,

	//初始化下级以下菜单
	updateAllLast : function(dataSrc, nLevel) {
		for(i = nLevel+1; i < this.MenuIdArr[dataSrc].length; i++) {
			childNode = $(this.MenuIdArr[dataSrc][i]);
			this.initBlank(childNode);
			childNode.disabled = true;
		}
	} ,

	//重新生成下级列表的值，初始化下级以下菜单
	initLinkage : function(dataSrc, sValue, nLevel) {
		nLevel = Number(nLevel);

		if (nLevel > this.MenuIdArr[dataSrc].length || nLevel < 1) {
			return;
		}

		currNode = $(this.MenuIdArr[dataSrc][nLevel-1]);
		childNode = $(this.MenuIdArr[dataSrc][nLevel]);

		if (currNode.disabled) {
			return;
		}

		for (i=0; i<currNode.options.length; i++) {
			if  (currNode.options[i].value  ==  sValue) {
				currNode.selectedIndex = i;
				break;
			}
		}

		if (childNode != null) {
			currArr = this.AllMenuArr[dataSrc][nLevel];
			this.initBlank(childNode);
			for(i=0; i<currArr.length; i++) {
				if  (currArr[i].parentValue  ==  sValue) {
					childNode.options.add(new Option(currArr[i].Desc, currArr[i].Value));
				}
			}
			if ((sValue != '') && (childNode.length > 1)) {
				childNode.disabled = false;
			} else {
				childNode.disabled = true;
			}
		}

		this.updateAllLast(dataSrc, nLevel);
	} ,

	changeLinkage : function(element) {
		this.initLinkage($V(element , "USEDATA"), $F(element), $V(element , "SUBCLASS"));
	} ,

	setDataSrc : function(dataSrc) {
		this.dataSrc = dataSrc;
	} ,

	setXmlFile : function(xmlFile) {
		this.xmlFile = xmlFile;
	} ,

	//初始化，加载数据，生成第一组下拉列表，初始化其它下拉列表
	init : function() {
		//得到XML文档的根节点
		var rootEle = loadXML(this.dataSrc, this.xmlFile);
		this.tree(this.dataSrc, rootEle);

		this.iDepth = -1;

		//初始化总数据数组
		for (i=0; i<this.MenuInfoArr[this.dataSrc].length; i++) {
			if (this.AllMenuArr[this.dataSrc] == null) {
				this.AllMenuArr[this.dataSrc] = new Array();
			}
			this.AllMenuArr[this.dataSrc].push(this.MenuInfoArr[this.dataSrc][i]);
		}

		//初始化应用元素数组
		var selectNodes = document.getElementsByTagName("select");
		for (i=0; i<selectNodes.length; i++) {
			if ($V(selectNodes[i] , "USEDATA") == this.dataSrc) {
				if (this.MenuIdArr[this.dataSrc] == null) {
					this.MenuIdArr[this.dataSrc] = new Array();
				}
				var subClass = Number($V(selectNodes[i] , "SUBCLASS")) - 1;
				this.MenuIdArr[this.dataSrc][subClass] = $V(selectNodes[i] , "id");
				Event.observe(selectNodes[i], "change", this.changeLinkage.bind(this, selectNodes[i]));
				//new Form.Element.EventObserver(selectNodes[i], this.changeLinkage.bind(this));
			}
		}

		//初始化第一个列表
		firstNode = $(this.MenuIdArr[this.dataSrc].first());
		this.initBlank(firstNode);
		for (i=0; i<this.AllMenuArr[this.dataSrc].first().length; i++) {
			firstNode.options.add(new Option(this.AllMenuArr[this.dataSrc].first()[i].Desc, this.AllMenuArr[this.dataSrc].first()[i].Value));
		}

		//初始化其它列表
		this.updateAllLast(this.dataSrc, 0);
	}
}


//基本数据对象(父名称及本身名称)
var MenuInfo = Class.create();
MenuInfo.prototype = {
	initialize : function(sParentValue, sValue, sDesc) {
		this.parentValue = sParentValue;
		this.Value = sValue;
		this.Desc = sDesc;
	}
}

//得到当前Element的属性值
function $V(ele, attr) {
	return ele.getAttribute(attr);
}

//生成XML对象
function createXMLDom() {
	if (window.ActiveXObject)
		var xmldoc = new ActiveXObject("Microsoft.XMLDOM");
	else
		if (document.implementation&&document.implementation.createDocument)
			var xmldoc = document.implementation.createDocument("","doc",null);
	xmldoc.async = false;
	//为了和FireFox一至，这里不能改为False;
	xmldoc.preserveWhiteSpace=true;
	return xmldoc;
} 

//加载XML数据
function loadXML(dataSrc, xmlFile) {
	if (xmlFile == null) {
		if (window.ActiveXObject) {
			return $(dataSrc).documentElement;
		} else {
			for (i=0; i<$(dataSrc).childNodes.length; i++) {
				if ($(dataSrc).childNodes[i].tagName != null) {
					return $(dataSrc).childNodes[i];
					break;
				}
			}
		}
	} else {
		var xmlDom = createXMLDom();
		try{
			xmlDom.load(xmlFile);
		}catch(e){
			alert("数据文件加载失败！");
		}
		return xmlDom.documentElement;
	}
}

/**
用作行业类别选项卡用，暂时内置在这个js文件里
*/
function changeTab(tabIndex)
    {
		tabCount = 4;
        for (i = 1; i <= tabCount; i++)
        {
            tab = document.getElementById("IndustryTab" + i);
            //content = document.getElementById("TopTenContent" + i);
            if (i == tabIndex)
            {
                tab.className = "menu_w14";
                //content.className = "activecontent";
            }
            else
            {
                tab.className = "menu";
                //content.className = "hiddencontent";
            }
        }
    }