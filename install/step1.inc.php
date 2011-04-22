<?php include 'header.share.php';?>
	<div class="content">
		<div id="installdiv">
		  <h3>欢迎您使用PHPB2B</h3>
		  <ul>
			<li>
			<p>PHPB2B™ is the most widely used open source b2b solution in the world. Like its predecessors, PHPB2B is feature-rich, user-friendly, and fully supported by the PHPB2B Team.</p>
			<p><br />本向导将指导您完成PHPB2B的正确安装。</p>
			<p><br />为了能够顺利完成安装，您需要将您的数据库设置提前准备好。如果您不知道您的数据库设置，请联系您的主机商，并要求他们提供给您相关信息，同时您的服务器必须要有如下配置：</p>

	<ul>
		<li>MySQL 3.23 或更高版本</li>
		<li>PHP 4.3.0 或更高版本</li>
	</ul>

	<p><strong>注意:</strong> PHPB2B目前仅支持Mysql数据库。</p>
	</li>
		  </ul>
		</div>
		<br />
		<input type="button" class="btn" onClick="$('#install').submit();" value="开始安装 PHPB2B" title="点击进入下一步" />
	</div>
	<form id="install" action="install.php" method="get">
	<input type="hidden" name="step" value="2">
	</form>
  </div>
</div>
</body>
</html>