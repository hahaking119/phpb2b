<!--//
$(document).ready(function(){   
	//event: "keyup",
    $("#regfrm").validate({
		rules: {
			"data[member][username]": { required: true,rangelength:[2,20]},
			"data[member][userpass]": { required: true},
			"data[member][email]": { required: true, email:true},
			"re_memberpass": { required: true, equalTo: "#memberpass"}
		},
		messages: {
			"data[member][username]": {
				required:"请输入正确的用户名",
				rangelength:"请输入介于2-20个字符的用户名"
			},
			"data[member][userpass]": "请输入密码",
			"data[member][email]": "请输入正确的Email",
			"re_memberpass": "请再次输入密码"
		}
	}); 
   $('#dataMemberUsername').blur(function (){
	 var username = $("#dataMemberUsername").val();
	 if(username.length<2){
		 return;
	 }
	 var params = "username="+username;
	 var action = "checkusername";
     $.ajax({
       url:'ajax.php?action='+action, //后台处理程序
       type:'get',         //数据发送方式
       dataType:'json',     //接受数据格式
       data:params,         //要传递的数据
       success:update_checkusernameDiv  //回传函数(这里是函数名)
     });
   });	
   $('#exchange_imgcapt').click(function (){
	 $('#imgcaptcha').attr('src','captcha.php?sid=' + Math.random());
	 $('#login_auth').focus();
	 return false;
   });	
   $('#dataMemberEmail').blur(function (){
	 var email = $("#dataMemberEmail").val();
	 if(email.length<5){
		 return;
	 }
	 var params = "email="+email;
	 var action = "checkemail";
     $.ajax({
       url:'ajax.php?action='+action, //后台处理程序
       type:'get',         //数据发送方式
       dataType:'json',     //接受数据格式
       data:params,         //要传递的数据
       success:update_checkemailDiv  //回传函数(这里是函数名)
     });
   });	
});
function update_checkusernameDiv(data){
	var errorNumber = data.isError;
	if(errorNumber!=0)
	{
		$("#Submit").attr('disabled', true);
		$("#membernameDiv").html('<img src="images/check_error.gif" alt="不能使用">用户名已经存在');
	}else{
		$("#Submit").attr('disabled', false);
		$("#membernameDiv").html('<img src="images/check_right.gif" alt="可以使用">');
	}
}
function update_checkemailDiv(data){
	var errorNumber = data.isError;
	if(errorNumber!=0)
	{
		$("#Submit").attr('disabled', true);
		$("#memberemailDiv").html('<img src="images/check_error.gif" alt="不能使用">Email已经存在');
	}else{
		$("#Submit").attr('disabled', false);
		$("#memberemailDiv").html('<img src="images/check_right.gif" alt="可以使用">');
	}
}
//-->