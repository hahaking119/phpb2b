// JavaScript Document

function getPassword(num,o)
{
	for(var i=0; i<2; i++)
	{
		document.getElementById("getbt" + i).className = "";
		document.getElementById("getpass" + i).style.display = "none";
	}
	o.className = "cur";
	document.getElementById("getpass" + num).style.display = "inline";
}