<?php include 'header.share.php';?>
	<div class="content" style="height:350px; overflow:auto;"><?php echo nl2br(str_replace(' ', '&nbsp;', htmlspecialchars($license)));?></div>
	<form id="install" action="install.php" method="get">
<input type="hidden" name="step" value="3">
 </form>
<a onclick="javascript:history.go(-1);" class="btn" title="返回上一步">返回上一步：<?php echo $steps[--$step];?></a>
<a onClick="$('#install').submit();" class="btn" title="运行环境检测"><span>同意协议，下一步</span></a>
  </div>
</div>
</body>
</html>

