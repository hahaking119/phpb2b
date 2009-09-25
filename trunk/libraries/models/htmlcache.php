<?php
class Htmlcaches extends PbModel {
	var $name = "Htmlcache";

	function updateCacheTime($mix_page_id){
		global $data, $time_stamp;
		$data['Htmlcache']['h_n'] = $mix_page_id;
		if(is_string($mix_page_id)){
			$id = $this->field("id", "h_n='".trim($mix_page_id)."'");
		}elseif(is_int($mix_page_id)){
			$id = trim($mix_page_id);
		}
		$data['Htmlcache']['h_l'] = $time_stamp;
		if($id){
			$result = $this->save($data['Htmlcache'], "update", $id);
		}else{
			$result = $this->save($data['Htmlcache']);
		}
		if($result){
			return true;
		}else{
			return false;
		}
	}

	function needRecache($mix_page_id){
		global $time_stamp;
		if(is_string($mix_page_id)){
			$id = $this->field("id", "h_n='".trim($mix_page_id)."'");
		}elseif(is_int($mix_page_id)){
			$id = trim($mix_page_id);
		}
		if(!empty($id)) {
			$tmp_result = $this->read("h_l as LastCacheTime, h_r as CacheCycle", $id);
			$time1 = intval($tmp_result['LastCacheTime']+$tmp_result['CacheCycle']);
			if($time1<=0 || $time_stamp>$time1){
				return true;
			}else{
				return false;
			}
		}else{
			return true;
		}
	}
}
?>