var NS;
if (!(NS=window.parent.__FCKeditorNS)) NS=window.parent.__FCKeditorNS=new Object();
Array.prototype.addItem=function(A)
{
	var i=this.length;
	this[i]=A;
	return i;
};
Array.prototype.indexOf=function(A)
{
	for (var i=0;i<this.length;i++)
	{
		if (this[i]==A) return i;
	};
	return-1;
};
String.prototype.startsWith=function(A)
{
	return (this.substr(0,A.length)==A);
};
String.prototype.endsWith=function(A,B)
{
	var C=this.length;
	var D=A.length;
	if (D>C) return false;
	if (B)
	{
		var E=new RegExp(A+'$','i');
		return E.test(this);
	}
	else return (D==0||this.substr(C-D,D)==A);
};
String.prototype.remove=function(A,B)
{
	var s='';
	if (A>0) s=this.substring(0,A);
	if (A+B<this.length) s+=this.substring(A+B,this.length);
	return s;
};
String.prototype.trim=function()
{
	return this.replace(/(^\s*)|(\s*$)/g,'');
};
String.prototype.ltrim=function()
{
	return this.replace(/^\s*/g,'');
};
String.prototype.rtrim=function()
{
	return this.replace(/\s*$/g,'');
};
String.prototype.replaceNewLineChars=function(A)
{
	return this.replace(/\n/g,A);
}
var FCK_STATUS_NOTLOADED=window.parent.FCK_STATUS_NOTLOADED=0;
var FCK_STATUS_ACTIVE=window.parent.FCK_STATUS_ACTIVE=1;
var FCK_STATUS_COMPLETE=window.parent.FCK_STATUS_COMPLETE=2;
var FCK_TRISTATE_OFF=window.parent.FCK_TRISTATE_OFF=0;
var FCK_TRISTATE_ON=window.parent.FCK_TRISTATE_ON=1;
var FCK_TRISTATE_DISABLED=window.parent.FCK_TRISTATE_DISABLED=-1;
var FCK_UNKNOWN=window.parent.FCK_UNKNOWN=-1000;
var FCK_EDITMODE_WYSIWYG=window.parent.FCK_EDITMODE_WYSIWYG=0;
var FCK_EDITMODE_SOURCE=window.parent.FCK_EDITMODE_SOURCE=1;
var FCKBrowserInfo;
if (!(FCKBrowserInfo=NS.FCKBrowserInfo))
{
	FCKBrowserInfo=NS.FCKBrowserInfo=new Object();
	var sAgent=navigator.userAgent.toLowerCase();
	FCKBrowserInfo.IsIE=(sAgent.indexOf("msie")!=-1);
	FCKBrowserInfo.IsGecko=!FCKBrowserInfo.IsIE;
	FCKBrowserInfo.IsSafari=(sAgent.indexOf("safari")!=-1);
	FCKBrowserInfo.IsNetscape=(sAgent.indexOf("netscape")!=-1);
};
var FCKScriptLoader=new Object();
FCKScriptLoader.IsLoading=false;
FCKScriptLoader.Queue=new Array();
FCKScriptLoader.AddScript=function(A)
{
	FCKScriptLoader.Queue[FCKScriptLoader.Queue.length]=A;
	if (!this.IsLoading) this.CheckQueue();
};
FCKScriptLoader.CheckQueue=function()
{
	if (this.Queue.length>0)
	{
		this.IsLoading=true;
		var A=this.Queue[0];
		var B=new Array();
		for (i=1;i<this.Queue.length;i++) B[i-1]=this.Queue[i];
		this.Queue=B;
		this.LoadFile(A);
	}
	else
	{
		this.IsLoading=false;
		if (this.OnEmpty) this.OnEmpty();
	};
};
FCKScriptLoader.LoadFile=function(A)
{
	var e;
	if (A.lastIndexOf('.css')>0)
	{
		e=document.createElement('LINK');
		e.rel='stylesheet';
		e.type='text/css';
	}
	else
	{
		e=document.createElement("script");
		e.type="text/javascript";
	};
	document.getElementsByTagName("head")[0].appendChild(e);
	if (e.tagName=='LINK')
	{
		if (FCKBrowserInfo.IsIE) e.onload=FCKScriptLoader_OnLoad;
		else FCKScriptLoader.CheckQueue();
		e.href=A;
	}
	else
	{
		e.onload=e.onreadystatechange=FCKScriptLoader_OnLoad;
		e.src=A;
	};
};
function FCKScriptLoader_OnLoad()
{
	if (this.tagName=='LINK'||!this.readyState||this.readyState=='loaded') FCKScriptLoader.CheckQueue();
}
var FCKURLParams=new Object();
var aParams=document.location.search.substr(1).split('&');
for (var i=0;i<aParams.length;i++)
{
	var aParam=aParams[i].split('=');
	var sParamName=aParam[0];
	var sParamValue=aParam[1];
	FCKURLParams[sParamName]=sParamValue;
}
var FCK=new Object();
FCK.Name=FCKURLParams['InstanceName'];
FCK.Status=FCK_STATUS_NOTLOADED;
FCK.EditMode=FCK_EDITMODE_WYSIWYG;
FCK.LoadLinkedFile=function()
{
	var A=window.parent.document;
	var B=A.getElementById(FCK.Name);
	var C=A.getElementsByName(FCK.Name);
	var i=0;
	while (B||i==0)
	{
		if (B&&(B.tagName=='INPUT'||B.tagName=='TEXTAREA'))
		{
			FCK.LinkedField=B;
			break;
		};
		B=C[i++];
	};
};
FCK.LoadLinkedFile();
var FCKTempBin=new Object();
FCKTempBin.Elements=new Array();
FCKTempBin.AddElement=function(A)
{
	var B=FCKTempBin.Elements.length;
	FCKTempBin.Elements[B]=A;
	return B;
};
FCKTempBin.RemoveElement=function(A)
{
	var e=FCKTempBin.Elements[A];
	FCKTempBin.Elements[A]=null;
	return e;
};
FCKTempBin.Reset=function()
{
	var i=0;
	while (i<FCKTempBin.Elements.length) FCKTempBin.Elements[i++]==null;
	FCKTempBin.Elements.length=0;
}
var FCKConfig=FCK.Config=new Object();
if (document.location.protocol=='file:')
{
	FCKConfig.BasePath=unescape(document.location.pathname.substr(1));
	FCKConfig.BasePath=FCKConfig.BasePath.replace(/\\/gi, '/');
	FCKConfig.BasePath='file://'+FCKConfig.BasePath.substring(0,FCKConfig.BasePath.lastIndexOf('/')+1);
}
else
{
	FCKConfig.BasePath=document.location.pathname.substring(0,document.location.pathname.lastIndexOf('/')+1);
	FCKConfig.FullBasePath=document.location.protocol+'//'+document.location.host+FCKConfig.BasePath;
};
FCKConfig.EditorPath=FCKConfig.BasePath.replace(/editor\/$/,'');
try
{
	FCKConfig.ScreenWidth=screen.width;
	FCKConfig.ScreenHeight=screen.height;
}
catch (e)
{
	FCKConfig.ScreenWidth=800;
	FCKConfig.ScreenHeight=600;
};
FCKConfig.ProcessHiddenField=function()
{
	this.PageConfig=new Object();
	var A=window.parent.document.getElementById(FCK.Name+'___Config');
	if (!A) return;
	var B=A.value.split('&');
	for (var i=0;i<B.length;i++)
	{
		if (B[i].length==0) continue;
		var C=B[i].split('=');
		var D=unescape(C[0]);
		var E=unescape(C[1]);
		if (D=='CustomConfigurationsPath') FCKConfig[D]=E;
		else if (E.toLowerCase()=="true") this.PageConfig[D]=true;
		else if (E.toLowerCase()=="false") this.PageConfig[D]=false;
		else if (!isNaN(E)) this.PageConfig[D]=parseInt(E);
		else this.PageConfig[D]=E;
	};
};
FCKConfig.LoadPageConfig=function()
{
	for (var A in this.PageConfig) FCKConfig[A]=this.PageConfig[A];
};
FCKConfig.ToolbarSets=new Object();
FCKConfig.ProtectedSource=new Object();
FCKConfig.ProtectedSource.RegexEntries=new Array();
FCKConfig.ProtectedSource.Add=function(A)
{
	this.RegexEntries.addItem(A);
};
FCKConfig.ProtectedSource.Protect=function(A)
{
function _Replace(protectedSource)
{
	var B=FCKTempBin.AddElement(protectedSource);
	return '<!--{PS..'+B+'}-->';
};
for (var i=0;i<this.RegexEntries.length;i++)
{
	A=A.replace(this.RegexEntries[i],_Replace);
};
return A;
};
FCKConfig.ProtectedSource.Revert=function(A,B)
{
	function _Replace(m,opener,index)
	{
		var C=B?FCKTempBin.RemoveElement(index):FCKTempBin.Elements[index];
		return FCKConfig.ProtectedSource.Revert(C,B);
	};
	return A.replace(/(<|&lt;)!--\{PS..(\d+)\}--(>|&gt;)/g,_Replace);
};
FCKConfig.ProtectedSource.Add(/<!--[\s\S]*?-->/g);
var FCKeditorAPI;
function FCKeditorAPI_GetInstance(instanceName)
{
	return this.__Instances[instanceName];
};
if (!window.parent.FCKeditorAPI)
{
	FCKeditorAPI=window.parent.FCKeditorAPI=new Object();
	FCKeditorAPI.__Instances=new Object();
	FCKeditorAPI.Version='2.2';
	FCKeditorAPI.GetInstance=FCKeditorAPI_GetInstance;
}
else FCKeditorAPI=window.parent.FCKeditorAPI;
FCKeditorAPI.__Instances[FCK.Name]=FCK;
if (FCKBrowserInfo.IsGecko)
{
function Window_OnResize()
{
	var oFrame=document.getElementById('eEditorArea');
	oFrame.height=0;
	var oCell=document.getElementById(FCK.EditMode==FCK_EDITMODE_WYSIWYG?'eWysiwygCell':'eSource');
	var iHeight=oCell.offsetHeight;
	oFrame.height=iHeight-2;
};
window.onresize=Window_OnResize;
};
if (FCKBrowserInfo.IsIE)
{
var aCleanupDocs=new Array();
aCleanupDocs[0]=document;
function Window_OnBeforeUnload()
{
	var d,e;
	var j=0;
	while ((d=aCleanupDocs[j++]))
	{
		var i=0;
		while ((e=d.getElementsByTagName("DIV").item(i++)))
		{
			if (e.FCKToolbarButton) e.FCKToolbarButton=null;
			if (e.Command) e.Command=null;
		};
		aCleanupDocs[j]=null;
	};
	if (typeof(FCKTempBin)!='undefined') FCKTempBin.Reset();
};
window.attachEvent("onunload",Window_OnBeforeUnload);
};
function Window_OnLoad()
{
	if (FCKBrowserInfo.IsNetscape) document.getElementById('eWysiwygCell').style.paddingRight='2px';
	LoadConfigFile();
};
window.onload=Window_OnLoad;
function LoadConfigFile()
{
	FCKScriptLoader.OnEmpty=ProcessHiddenField;
	FCKScriptLoader.AddScript('../fckconfig.js');
};
function ProcessHiddenField()
{
	FCKConfig.ProcessHiddenField();
	LoadCustomConfigFile();
};
function LoadCustomConfigFile()
{
	if (FCKConfig.CustomConfigurationsPath.length>0)
	{
		FCKScriptLoader.OnEmpty=LoadPageConfig;
		FCKScriptLoader.AddScript(FCKConfig.CustomConfigurationsPath);
	}
	else
	{
		LoadPageConfig();
	};
};
function LoadPageConfig()
{
	FCKConfig.LoadPageConfig();
	LoadStyles();
};
function LoadStyles()
{
	FCKScriptLoader.OnEmpty=LoadScripts;
	FCKScriptLoader.AddScript(FCKConfig.SkinPath+'fck_editor.css');
};
function LoadScripts()
{
	FCKScriptLoader.OnEmpty=null;
	if (FCKBrowserInfo.IsIE) FCKScriptLoader.AddScript('js/fckeditorcode_ie_1.js');
	else FCKScriptLoader.AddScript('js/fckeditorcode_gecko_1.js');
};
function LoadLanguageFile()
{
	FCKScriptLoader.OnEmpty=LoadEditor;
	FCKScriptLoader.AddScript('lang/'+FCKLanguageManager.ActiveLanguage.Code+'.js');
};
function LoadEditor()
{
	FCKScriptLoader.OnEmpty=null;
	if (FCKLang) window.document.dir=FCKLang.Dir;
	FCK.StartEditor();
}
