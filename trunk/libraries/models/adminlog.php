<?php
 class Adminlogs extends UaModel {
 	var $name = "Adminlog";

 	function Adminlogs()
 	{

 	}

	function add($result = true)
	{
		global $time_stamp;
		global $data;
		if(!empty($data['Adminlog'])) {
			if(!isset($data['Adminlog']['adminer_id'])) $data['Adminlog']['adminer_id'] = $_SESSION['admin']['current_adminer_id'];
			if(!isset($data['Adminlog']['created'])) $data['Adminlog']['created'] = $time_stamp;
			if(!isset($data['Adminlog']['ip_address'])) $data['Adminlog']['ip_address'] = uaIp2Long(uaGetClientIP());
			$result = $this->save($data['Adminlog']);
		}
		return $result;
	}
}
?>