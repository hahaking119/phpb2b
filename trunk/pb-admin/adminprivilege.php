<?php
$inc_path = "../";
$ua_sm_compile_dir = "pb-admin/";
require($inc_path."global.php");
require(SITE_ROOT. './configs/db_session.php');
uses("adminrole","adminer","adminmodule","adminprivilege");
require("session_cp.inc.php");
$adminprivilege = new Adminprivileges();
$adminmodule = new Adminmodules();
$adminrole = new Adminroles();
$adminer = new Adminers();
$conditions = null;
$sql = "select Adminmodule.id as AdminmoduleId,Adminmodule.name as AdminmoduleName,Adminprivilege.adminer_id as AdminerId from ".$adminmodule->getTable(true)." left join ".$adminprivilege->getTable(true)." on Adminmodule.id=Adminprivilege.adminmodule_id and Adminprivilege.adminer_id=1 where Adminmodule.level=1;";
$level1_adminmodules = $g_db->GetArray($sql);

if (isset($_POST['save'])) {
	unset($_POST['save']);
	$gt = array_values($_POST);
	$adminer_id = intval($_GET['adminerid']);
	$tg = array();
	foreach ($gt as $gkey=>$gval) {
		if (is_array($gval)) {
			foreach ($gval as $ggval) {
				$tg[] = "(".$adminer_id.",".$ggval.")";
			}
		}else {
			$tg[] = "(".$adminer_id.",".$gval.")";
		}
	}
	$inss = implode(",", $tg);
	$sql = "delete from ".$adminprivilege->getTable()." where adminer_id=".$adminer_id;
	$result = $g_db->Execute($sql);
	$sql = "insert into ".$adminprivilege->getTable()." (adminer_id,adminmodule_id) values ".$inss.";";
	$result = $g_db->Execute($sql);
	unset($sql, $tg, $gt);
	if ($result) {
		flash("alert.php", "adminer.php");
	}
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<{#Charset#}>">
<link rel="stylesheet" type="text/css" href="css/main.css">
<script language="javascript" src="<{$JS_PATH}>js/general.js"></script>
<script language="javascript" src="<{$JS_PATH}>js/admin.js"></script>
<script language=Javascript>
function CheckAll(obj,theid){
	for (var i=0;i<obj.elements.length;i++){
		var e=obj.elements[i];
		if (e.parentid==theid) e.checked=document.all[theid].checked;
	}
}

function CheckAlll(form)
{
	for (var i=0;i<form.elements.length;i++)
	{
		var e = form.elements[i];
		if (e.Name != "chkAll[]" && e.disabled==false)
		e.checked = form.chkAlll.checked;
	}
}

function CheckAllll(e, itemName)
{
  var aa = document.getElementsByName(itemName);
  for (var i=0; i<aa.length; i++)
   aa[i].checked = e.checked;
}
</script>
<style>
#menu ul {list-style: none; }
.action ul li{list-style: none; display:inline; }
</style>
</head>

<body leftmargin="10" topmargin="10">
<table width="100%" border="0" cellpadding="2" cellspacing="6"><tr><td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="guide"><tr>
  <td><div align="left">管理员权限管理</div></td>
</tr></table>
<form name="privilegefrm" method="post" action="<?php echo $PHP_SELF;?>?adminerid=<?php echo $_GET['adminerid'];?>">
<div id="menu0" style=" border: double"><input name="chkAll" type="checkbox" id="chkAlll" onClick="CheckAlll(this.form)" value="selectAll"><label for="chkAlll">全选</label>
	<div id="menu">
		<ol>
		<!-- 一级权限循环开始 -->
		<?php
		foreach ($level1_adminmodules as $key_1=>$val_1) :
		$this_parent_id = $val_1['AdminmoduleId'];
			?>
			<li><input type="checkbox" name="chkAll[]" id="id_<?php echo $val_1['AdminmoduleId'];?>" value="<?php echo $val_1['AdminmoduleId'];?>" onClick="CheckAll(this.form,this.id)" <?php if(!empty($val_1['AdminerId'])) echo "checked";?> /><label for="id_<?php echo $val_1['AdminmoduleId'];?>"><strong><?php echo $val_1['AdminmoduleName'];?></strong></label><div id="menu_<?php echo $val_1['AdminmoduleId'];?>" style="border: dashed; color: #004080"><ul>
            <!-- 循环level2 -->
            <?php
			$sql = "select Adminmodule.id as AdminmoduleId,Adminmodule.name as AdminmoduleName,Adminprivilege.adminer_id as AdminerId from ".$adminmodule->getTable(true)." left join ".$adminprivilege->getTable(true)." on Adminmodule.id=Adminprivilege.adminmodule_id and Adminprivilege.adminer_id=1 where Adminmodule.level=2 and Adminmodule.parent_id=".$this_parent_id.";";
			$level2_adminmodules = $g_db->GetArray($sql);
			foreach($level2_adminmodules as $key_2=>$val_2) :
			$the_2_id = $val_2['AdminmoduleId'];
			?>
            <li><input type="checkbox" name="act<?php echo $the_2_id;?>all" id="id_<?php echo $the_2_id;?>" parentid="id_<?php echo $this_parent_id;?>" onClick="CheckAllll(this, 'act<?php echo $the_2_id;?>[]')" value="<?php echo $the_2_id;?>" <?php if(!empty($val_2['AdminerId'])) echo "checked";?> /><label for="id_<?php echo $the_2_id;?>"><?php echo $val_2['AdminmoduleName'];?></label><ul>
            <!-- 循环level3 -->
            <?php
			$sql = "select Adminmodule.id as AdminmoduleId,Adminmodule.name as AdminmoduleName,Adminprivilege.adminer_id as AdminerId from ".$adminmodule->getTable(true)." left join ".$adminprivilege->getTable(true)." on Adminmodule.id=Adminprivilege.adminmodule_id and Adminprivilege.adminer_id=1 where Adminmodule.level=3 and Adminmodule.parent_id=".$the_2_id.";";
			$level3_adminmodules = $g_db->GetArray($sql);
			foreach($level3_adminmodules as $key_3=>$val_3) :
			$the_3_id = $val_3['AdminmoduleId'];
			?>
            <li><input type="checkbox" name="act<?php echo $the_2_id;?>[]" id="id_<?php echo $the_3_id;?>" value="<?php echo $the_3_id;?>" parentid="id_<?php echo $this_parent_id;?>" <?php if(!empty($val_3['AdminerId'])) echo "checked";?> /><label for="id_<?php echo $the_3_id;?>"><?php echo $val_3['AdminmoduleName'];?></label>
            <!-- 最细权限div开始 -->
            <div class="action" id="action1"><ul>
            <!-- 循环level4 -->
            <?php
			$sql = "select Adminmodule.id as AdminmoduleId,Adminmodule.name as AdminmoduleName,Adminprivilege.adminer_id as AdminerId from ".$adminmodule->getTable(true)." left join ".$adminprivilege->getTable(true)." on Adminmodule.id=Adminprivilege.adminmodule_id and Adminprivilege.adminer_id=1 where Adminmodule.level=4 and Adminmodule.parent_id=".$the_3_id.";";
			$level4_adminmodules = $g_db->GetArray($sql);
			foreach($level4_adminmodules as $key_4=>$val_4) :
			$the_4_id = $val_4['AdminmoduleId'];
			?>
            <li><input type="checkbox" name="act<?php echo $the_2_id;?>[]" id="id_<?php echo $the_4_id;?>" value="<?php echo $the_4_id;?>" parentid="id_<?php echo $this_parent_id;?>" <?php if(!empty($val_4['AdminerId'])) echo "checked";?> /><label for="id_<?php echo $the_4_id;?>"><?php echo $val_4['AdminmoduleName'];?></label></li>
            <?php
			endforeach;//level4循环结束
			?>
            </ul></div>
            <!-- 最细权限结束 -->
            </li>
            <?php
			endforeach;//level3结束
			?>
            </ul></li>
            <?php
			endforeach;//level2结束
			?>
            </ul></div></li>
		<?php
		endforeach;
		?>
		</ol>
	</div>
</div>
<div align="center"><input type="submit" name="save" value="保存" />
</div>
</form>
</body>
</html>