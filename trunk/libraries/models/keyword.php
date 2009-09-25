<?php
 class Keywords extends PbModel {
	var $name = "Keyword";
 	var $type_condition;
 	var $exist_keyword_id = array();
 	var $inserted_keyword_id = array();

 	function Keywords()
 	{

 	}

	function checkKeyExists($keyword)
	{
		$this->primaryKey = "title";
		$res = $this->read("Keyword.id,Keyword.type AS KeywordType",$keyword);
		if(empty($res) || !$res){
			return false;
		}else {
			return $res;
		}
	}

	function setKeywordId($keys, $prim_id, $type_id)
	{
	    global $g_db, $tb_prefix, $_SESSION;
	    if(!empty($keys)){
	        $words = str_replace(array("，", " ", "　"), ",", $keys);
	        $words = explode(",", $words);
	        foreach ($words as $key=>$val){
	            $val = trim($val);
	            $kid = $g_db->GetOne("select id from {$tb_prefix}keywords where title='".$val."' and type='$type_id'");
	            //关键字是否存在
	            if ($kid) {
	                $pid = $g_db->GetOne("select primary_id from {$tb_prefix}keywords where id=".$kid);
	                if ($pid) {
	                    //该关键字已经收录了产品
	                    $exist_ids = explode(",", $pid);
	                    if(!in_array($prim_id, $exist_ids)) {
	                        $exist_ids[] = $prim_id;
	                        $exist_ids = implode(",", $exist_ids);
	                        $g_db->Execute("update {$tb_prefix}keywords set primary_id='".$exist_ids."' where id=".$kid);
	                        $this->exist_keyword_id[] = $kid;
	                    }
	                }else{
	                    $g_db->Execute("update {$tb_prefix}keywords set primary_id='".$prim_id."' where id=".$kid);
	                    $this->exist_keyword_id[] = $kid;
	                }
	            }else{
	                $g_db->Execute("insert into {$tb_prefix}keywords (title,primary_id,member_id,type,created) valued ('$val','$prim_id','".$_SESSION['MemberID']."','$type_id','".date("Y-m-d H:i:s")."')");
	                $this->inserted_keyword_id[] = $g_db->Insert_ID();
	            }
	        }
	    }
		unset($exist_ids, $kid, $pid, $words);
	}

	function getKeywordId()
	{
		$ids = array_merge($this->exist_keyword_id, $this->inserted_keyword_id);
		$ids = implode(",", $ids);
		return $ids;
	}

	function delKeywordIdFromPrimary($id, $old_keyword_ids, $type_id, $prim_id)
	{

	}
}