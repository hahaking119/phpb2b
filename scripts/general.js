<!--
/**
 * select all or none
 */
function uaCheckAll(e, itemName)
{
  var aa = document.getElementsByName(itemName);
  for (var i=0; i<aa.length; i++)
   aa[i].checked = e.checked;
}

function uaCheckItem(e, allName)
{
  var all = document.getElementsByName(allName)[0];
  if(!e.checked) all.checked = false;
  else
  {
    var aa = document.getElementsByName(e.name);
    for (var i=0; i<aa.length; i++)
     if(!aa[i].checked) return;
    all.checked = true;
  }
}

/**
 * Check Emaill Address
 */
function chkemail(a)
{ var i=a.length;
 var temp = a.indexOf('@');
 var tempd = a.indexOf('.');
 if (temp > 1) {
  if ((i-temp) > 3){
   
    if ((i-tempd)>0){
     return 1;
    }
   
  }
 }
 return 0;
}

//Count String Length
function ByteWordCount(value) {
  var txt = value;
  txt = txt.replace(/(<.*?>)/ig,'');  
  txt = txt.replace(/([\u0391-\uFFE5])/ig,'11');
  return txt.length;
}

//check num
function fucCheckNUM(NUM)
{
 var i,j,strTemp;
 strTemp="0123456789";
 if ( NUM.length== 0)
  return 0
 for (i=0;i<NUM.length;i++)
 {
  j=strTemp.indexOf(NUM.charAt(i)); 
  if (j==-1)
  {
   return 0;
  }
 }
 return 1;
}

//instead of fucCheckNUM
function isNumber(oNum)
{
	if(!oNum) return false;
	var strP=/^\d+(\.\d+)?$/;
	if(!strP.test(oNum)) return false;
	try{
	if(parseFloat(oNum)!=oNum) return false;
	}
	catch(ex)
	{
		return false;
	}
	return true;
}

function preview(){	
	var x = $("#uploadfile");	
	var y = $("#uploadpic");
	var z = $("#uploadpic_hover");
	if(!x || !x.val() || !y) return;	
	var patn = /\.jpg$|\.jpeg$|\.gif$|\.png$/i;	
	if(patn.test(x.val())){		
		y.attr("src", "file://localhost/"+x.val());	
		z.attr("href", "file://localhost/"+x.val());	
	}else{		
		alert("What you select is not a picture?");	
	}
}

function confirmAction(message){
	if(window.confirm(message)){
		return true;
	}else{
		return false;
	}
}

function checkLength(which) {  
	var maxChars = 250;  
	if (which.value.length > maxChars)  
	which.value = which.value.substring(0,maxChars);  
	var curr = maxChars - which.value.length;  
	document.getElementById("chLeft").innerHTML = curr.toString();  
}

function StrLength(sString)
{
	var sStr,iCount,i,strTemp ; 

	iCount = 0 ;
	sStr = sString.split("");
	for (i = 0 ; i < sStr.length ; i ++)
	{
	strTemp = escape(sStr[i]); 
	if (strTemp.indexOf("%u",0) == -1)
	{ 
	iCount = iCount + 1 ;
	} 
	else 
	{
	iCount = iCount + 2 ;
	}
	}
	return iCount ;
}

function ismaxlength(obj){
	var mlength=obj.getAttribute? parseInt(obj.getAttribute("maxlength")) : ""
	if (obj.getAttribute && obj.value.length>mlength)
	obj.value=obj.value.substring(0,mlength)
}

function BookmarkIt(pageUrl, pageTitle)
{
	window.external.addFavorite(pageUrl, pageTitle);
}

function jsDateDiff(publishTime){
	//dateSeperate = "-"
	var d_minutes,d_hours,d_days;
	var timeNow = parseInt(new Date().getTime()/1000);
	var d;
	d = timeNow - publishTime;
	d_days = parseInt(d/86400);
	d_hours = parseInt(d/3600);
	d_minutes = parseInt(d/60);
	if(d_days>0 && d_days<4){
		return d_days+"天前";
	}else if(d_days<=0 && d_hours>0){
		return d_hours+"小时前";
	}else if(d_hours<=0 && d_minutes>0){
		return d_minutes+"分钟前";
	}else{
		var s = new Date(publishTime*1000);
		//s.getFullYear()+"年";
		return (s.getMonth()+1)+"月"+s.getDate()+"日";
	}
}

function   myAddPanel(title,url,desc)  
{  
	if   ((typeof   window.sidebar   ==   'object')   &&   (typeof   window.sidebar.addPanel   ==   'function'))//Gecko  
	{  
		window.sidebar.addPanel(title,url,desc);  
	}  
	else//IE  
	{  
		window.external.AddFavorite(url,title);  
	}  
}

function check_keywords(){
	var keywords = document.formsearch.q.value;
	if(keywords=="" || keywords=="输入关键字"){
		alert("请输入搜索关键字");
		document.formsearch.q.focus();
		return false;
	}else{
		return true;
	}
}

function login(frm){
	if(document.getElementById('login_name_banner').value == ""){
			alert("请输入登陆名");
			document.getElementById('login_name_banner').focus();
			return false;
		}else if(document.getElementById('login_pass_banner').value == ""){
			alert("请输入登陆密码");
			document.getElementById('login_pass_banner').focus();
			return false;
		}else{
			return true;
			}
}

function redirect(url){         
	window.location.href = url;
}
//-->