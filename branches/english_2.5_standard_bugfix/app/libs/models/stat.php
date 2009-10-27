<?php
 class Stats extends UaModel {
 	var $name = "Stat";

 	function Stats()
 	{

 	}

 	function Add($stat_name)
 	{
 		global $g_db, $tb_prefix;
        $sql = "update ".$tb_prefix."stats set sc=sc+1 where sb='$stat_name'";
        $result = $g_db->Execute($sql);
 	}
}
?>