// JavaScript Document

//行业扫描 tab切换 js code
function zx_tabchange(num)
{
	var haRy = document.getElementById("z_bt").getElementsByTagName("h2");
	for(var i=0; i<haRy.length; i++)
	{
		haRy[i].className = '';
		document.getElementById("z_tab" + i).style.display = "none";
	}
	haRy[num].className = "over";
	document.getElementById("z_tab" + num).style.display = "inline";
}