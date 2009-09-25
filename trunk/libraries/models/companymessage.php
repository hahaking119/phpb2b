<?php
class Companymessages extends PbModel  {
 	
 	var $name = "Companymessage";
	var $common_cols = "CompanyMessage.id AS ID,CompanyMessage.title AS Title,CompanyMessage.created AS CreateDate,CompanyMessage.from_member_id AS FromMemberID,to_member_id AS ToMemberID,CompanyMessage.status AS Status,Member.username AS MemberUserName";
 	function Companymessages()
 	{
 		
 	}
}
?>