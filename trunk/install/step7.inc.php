<?php include 'header.share.php';?>
   <?php if(!empty($db_error)){ ?>
   
    <div id="installmessage" style="height:150px; overflow:auto;" class="content">数据库链接失败<br />
    </div>
	<a href="javascript:history.go(-2);" class="btn">返回：数据库及管理员设置</a>
	<?php }else{ ?>
	 <div id="installmessage" style="height:50px; overflow:auto; line-height:50px; font-size:28px; font-weight:bold;  padding-left:215px;" class="content">安装成功</div>
     <div class="installmessage_img"></div>
     <div class="suc">
	<p>网站前台：<a href="<?php echo $siteUrl;?>" target="_blank"><?php echo $siteUrl;?></a></p>
	<p>登录商务室：<a href="<?php echo $siteUrl;?>logging.php" target="_blank"><?php echo $siteUrl;?>logging.php</a></p>
	<p>进入控制台：<a href="<?php echo $siteUrl;?>pb-admin/login.php" target="_blank"><?php echo $siteUrl;?>pb-admin/login.php</a></p>

	</div>
	
	<?php } ?>
<form id="install" action="install.php?step=7" method="post">
<input type="hidden" name="step" value="7">
</form>
</div>
</body>
</html>