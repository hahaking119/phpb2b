<?php
class Member extends PbController {
	var $name = "Member";

	function updatePassword($memberid, $newpassword)
	{
		$this->saveField();
	}
}