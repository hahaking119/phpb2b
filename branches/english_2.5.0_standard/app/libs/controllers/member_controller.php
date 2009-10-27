<?php
class Member extends UaController {
	var $name = "Member";

	function updatePassword($memberid, $newpassword)
	{
		$this->saveField();
	}
}