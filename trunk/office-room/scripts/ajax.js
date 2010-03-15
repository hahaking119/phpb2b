<!--//
$(document).ready(function() {    
   $('#oldpass').blur(function (){
     var params=$('#ChangePassFrm').serialize(); //序列化表单的值
     $.ajax({
       url:'../ajax.php', //后台处理程序
       type:'post',         //数据发送方式
       dataType:'json',     //接受数据格式
       data:params,         //要传递的数据
       success:update_checkoldpwdDiv  //回传函数(这里是函数名)
     });
   });
});
//-->