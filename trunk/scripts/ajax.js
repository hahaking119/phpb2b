<!--//
$(document).ready(function() {    
   $('#dataMemberUsername').blur(function (){
	 var params = $('#getPasswdFrm').serialize(); //序列化表单的值
	 var action = "checkusername";
     $.ajax({
       url:'ajax.php?action='+action, //后台处理程序
       type:'get',         //数据发送方式
       dataType:'json',     //接受数据格式
       data:params,         //要传递的数据
       success:update_checkusernameDiv  //回传函数(这里是函数名)
     });
   });
});
//-->