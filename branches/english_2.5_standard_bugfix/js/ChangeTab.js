// JavaScript Document

//行业扫描 tab切换 js code
function tabChangge(bt,tab,count,id)
{
	var haRy = document.getElementById(bt).getElementsByTagName("h2");
	for(var i=0; i<count; i++)
	{
		haRy[i].className = '';
		document.getElementById(tab + i).style.display = "none";
	}
	haRy[id].className = "over";
	document.getElementById(tab + id).style.display = "inline";
}