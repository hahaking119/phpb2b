<img src="captcha.php?sid=<?php echo md5(uniqid(time())); ?>" id="image" align="absmiddle" />
<a href="play.php" style="font-size: 13px">(Audio)</a><br /><br />

<a href="#" onclick="document.getElementById('image').src = 'captcha.php?sid=' + Math.random(); return false">Reload Image</a>
