<?php 
include 'header.share.php';?>
<div class="content">
<form id="install" action="install.php?step=7" method="post">
<input type="hidden" name="step" value="7">
<input type="hidden" name="dbhost" value="<?php echo $dbhost;?>">
<input type="hidden" name="dbuser" value="<?php echo $dbuser;?>">
<input type="hidden" name="dbname" value="<?php echo $dbname;?>">
<input type="hidden" name="dbpw" value="<?php echo $dbpasswd;?>">
<input type="hidden" name="tablepre" value="<?php echo $tablepre;?>">
<input type="hidden" name="dbcharset" value="<?php echo $dbcharset;?>">
<input type="hidden" name="pconnect" value="<?php echo $pconnect;?>">
<input type="hidden" name="username" value="<?php echo $username;?>">
<input type="hidden" name="password" value="<?php echo $password;?>">
<input type="hidden" name="email" value="<?php echo $email;?>">
<input type="hidden" name="createdb" value="<?php echo $createdb;?>">
<input type="hidden" name="password_key" value="<?php echo $passwordkey;?>">
<?php if($db_error){ ?>
<span class="error">数据库链接错误，请返回上一步重新配置</span>
<input type="button" onclick="javascript:history.go(-1);" value="返回上一步 : <?php echo $steps[--$step];?>" class="btn" />
<?php }else{ ?>
<table width="100%" cellpadding="0" cellspacing="0">
<caption>请输入网站的基本资料</caption>
<tr>
<th>选择语言：</th>
<td><select name="app_lang"><option value="zh-cn">简体中文</option></select><span> 如果你要修改网站语言,请在languages目录中添加相应语言包</span></td>
</tr>
<tr>
<th>网站名称：</th>
<td><input name="sitename" type="text" id="sitename" value="一个新的B2B网站" style="width: 200px;" /><span> 用于网站中使用的名称</span></td>
</tr>
<tr>
<th>网站标题：</th>
<td><input name="sitetitle" type="text" id="sitetitle" value="一个新的B2B网站的标题" style="width: 200px;" /><span> 显示在网站的标题栏以及网页的标题上</span></td>
</tr>
<tr>
<th>网站地址：</th>
<td><input name="siteurl" type="text" id="siteurl" value="<?php echo $siteUrl;?>" style="width: 200px;" /><span> 请输入网站的访问URL，一般保持默认即可</span></td>
</tr>
<tr>
<th>演示数据：</th>
<td><input type="checkbox" name="testdata" id="TestData" value="testdata" />
<label for="TestData"><span class="disabletxt">&nbsp;导入演示数据</span> (用于新手和调试用户)</label></td>
</tr>
</table>
</form>
</div>

<input type="button" onclick="javascript:history.go(-1);" value="返回上一步 : <?php echo $steps[--$step];?>" class="btn" />
<input type="button" onClick="$('#install').submit();$('#btn_installnow').attr('disabled',true);" id="btn_installnow" class="btn" value="下一步：安装" />
<?php } ?>
</div>
</div>
</body>
</html>
