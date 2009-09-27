<?php
class Companylinks extends UaModel {

 	
 	var $name = "Companylink";
 	var $common_cols = "Companylink.id AS CompanylinkId,Companylink.companyid1 AS MasterID,Companylink.companyid2 AS FriendID,Company.name AS FriendName,Companylink.friendlogo AS CompanyFriendlog";

 	function Companylinks()
 	{
 		
 	}

	function checkID($id,$memberid)
	{
		$sql = "SELECT id AS ID FROM ".$this->getTable(true)." AS Companylink WHERE id = ".$id." AND member_id = ".$memberid;
		$res = $GLOBALS['g_db']->GetOne($sql);
		if (!empty($res)) {
			return true;
		}else {
			return false;
		}
	}
}
?>