<?php include 'header.share.php';?>
<div class="content">
<form id="install" name="myform" action="install.php?step=6" method="post">
<input type="hidden" name="step" value="6">
<table width="100%" cellspacing="1" cellpadding="0" >
<caption>填写数据库信息</caption>
<tr>
<th width="30%" align="right" >数据库主机：</th>
<td><label>
  <input name="dbhost" type="text" id="dbhost" value="localhost" style="width:120px" />
</label></td>
</tr>
<tr>
<th align="right">数据库帐号：</th>
<td><input name="dbuser" type="text" id="dbuser" value="root" style="width:120px" /></td>
</tr>
<tr>
<th align="right">数据库密码：</th>
<td><input name="dbpw" type="password" id="dbpw" value="123456" style="width:120px" /></td>
</tr>
<tr>
<th align="right">数据库名称：</th>
<td><input name="dbname" type="text" id="dbname" value="phpb2b" style="width:120px" />
        如果不存在,则：<label for="db_create1"><input name="db[create]" type="radio" id="db_create1" checked="checked" value="1" />新建</label><label for="db_create2"><input name="db[create]" type="radio" id="db_create2" value="2" />不安装</label></td>
</tr>
<tr>
<th align="right">数据表前缀：</th>
<td><input name="tablepre" type="text" id="tablepre" value="pb_" style="width:120px" />  <img src="images/help.gif" style="cursor:pointer;" title="如果一个数据库安装多个应用程序,请修改表前缀,最好不要改动" align="absmiddle" />
<span id='helptablepre'></span></td>
</tr>
</table>

<table width="100%" cellspacing="1" cellpadding="0">
<caption>填写管理员信息</caption>
  <tr>
	<th width="30%" align="right">管理员帐号：</th>
	<td><input name="username" type="text" id="username" value="admin" style="width:120px" /> 2到20个字符，不含非法字符！<font color="FFFF00">（默认为 admin）</font></td>
  </tr>
  <tr>
	<th align="right">密码：</th>
	<td><input name="password" type="text" id="password" value="" style="width:120px" /> 3到20个字符<font color="FFFF00">（默认为 admin&nbsp;<a href="javascript:;" onclick="$('#password').val(suggestPassword());"><img src="images/auth.gif" border="0" /></a>）</font></td>
  </tr>
  <tr>
	<th align="right">确认密码：</th>
	<td><input name="pwdconfirm" type="text" id="pwdconfirm" value="" style="width:120px"/></td>
  </tr>
  <tr>
	<th align="right">E-mail：</th>
	<td><input name="email" type="text" id="email" value="" style="width:120px"/>
		</td>
  </tr>
   <tr>
	<th align="right">通信密钥：</th>
	<td><input name="password_key" type="text" id="password_key" value="" style="width:120px"/><font color="FFFF00">（网站通信密钥，若不填写则系统自动生成一个&nbsp;<a href="javascript:;" onclick="$('#password_key').val(suggestPassword());"><img src="images/auth.gif" border="0" /></a>）</font>
	</td>
  </tr>
</table>
</form>
<a href="javascript:history.go(-1);" class="btn">返回上一步：<?php echo $steps[--$step];?></a>
<input type="button" name="completeInstall" onclick="checkform()" class="btn" value="下一步：填写网站基本信息" />
</div>
</div>
</div>
</body>
</html>