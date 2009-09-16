<?php
class Industries extends UaModel {


	var $name = "Industry";

 	function Industries()
 	{

 	}

	function getIndustries($limit_b=0,$limit_e=1,$conditions = null)
	{
		$sql = "SELECT id AS ID,name AS Name,parentid AS ParentID ";
		$sql.= "FROM ".$this->getTable(true)." ";
		$sql.= "WHERE 1 ".$conditions;
		if(!is_null($limit_b) && !is_null($limit_e))
		$sql.= " limit $limit_b,$limit_e";
		$res = $GLOBALS['g_db']->GetAll($sql);
		return $res;
	}

	function getAllIndustry($conditions = null, $limit = null, $offset = null)
	{
		$sql = "SELECT Industry.id AS ID,name AS Name,parentid AS ParentID,product_amount AS ProductAmount,if_show_module AS IndustryIa,if_setby_market AS IndustryIb,sell_amount AS SellAmount,buy_amount AS BuyAmount,company_amount AS CompanyAmount,product_amount,sell_amount,buy_amount,company_amount ";
		$sql.= "FROM ".$this->getTable(true)." ";
		$sql.= "WHERE 1 ";
		$sql.= $conditions;
		$sql.= " ORDER BY Industry.id ";
		if(!is_null($limit) && !is_null($offset)) $sql.= " LIMIT $limit,$offset";
		$tmp_arr = $GLOBALS['g_db']->GetAll($sql);
		return $tmp_arr;
	}

	function getIndustyName($id)
	{
		$id = intval($id);
		$indname = $GLOBALS['g_db']->GetOne("SELECT name AS Name FROM ".$this->getTable(true)." WHERE id=".$id);
		if(empty($indname) || !$indname)
		{
			return false;
		}
		else
		{
			return $indname;
		}
	}

	function searchParentIndustry($id)
	{
		$parents = null;
		$have_parent = $GLOBALS['g_db']->GetOne("SELECT parentid FROM ".$this->getTable(true)." WHERE Industry.id=".$id);
		if($have_parent){

			$parents = $this->searchParentIndustry($have_parent);
		}
		$parents[] = $id;
		return $parents;
	}

	/**
	* 得到父分类的子分类
	* @return array
	*/
	function getSubIndustries($sid){
		global $g_db;
		$sql = "select id from ".$this->getTable()." where parentid=".$sid;
		$res = $g_db->GetArray($sql);
		if(!empty($res)){
			foreach($res as $key=>$val){
				$return[] = $val['id'];
			}
		}else{
			$return[] = $sid;
		}
		$return = implode(",", $return);
		return $return;
	}

	function getIndustryPage($model_id, $model_index, $templet = null)
	{
	    global $smarty, $theme_name;
	    require(CACHE_PATH."industry.inc.php");
		if(empty($templet)) $templet = "industry1";
	    $smarty->assign("AmountTypeLi", $model_id);
	    switch ($model_index) {
	    	case "buy":
	    		$url = URL."offer/list.php?";
	    		break;
	    	case "sell":
	    	    $url = URL."offer/list.php?";
	    	    break;
	    	case "company":
	    	    $url = URL."company/list.php?";
	    	    break;
	    	case "product":
	    	    $url = URL."product/list.php?";
	    	    break;
	    	case "hr":
	    	    $url = URL."hr/index.php?ac=list&";
	    	    break;
	    	default:
	    		break;
	    }
	    $smarty->assign("url", $url);
	    $smarty->assign("IndustryList", $CACHE_P_INDUSTRY);
	    return $smarty->fetch($theme_name."/elements/".$templet.".html");
	}

	function updateModelAmount($industry_id, $model_name, $write = true)
	{
	    global $g_db;
	    $if_parent = false;
	    $models = array("buy_amount", "sell_amount", "product_amount", "company_amount");
	    if (!in_array($model_name, $models)) {
	    	return false;
	    }
	    //if is not parent , also update it's parent amount.
	    $parent_id = $this->field("parentid", "id=".$industry_id);
	    if ($parent_id==0) {
	    	$if_parent = true;
	    }

	    if (!$if_parent) {
	    	$sql = "update ".$this->getTable()." set ".$model_name."=".$model_name."+1 where id in (".$industry_id.",".$parent_id.")";
	    }else{
	       $sql = "update ".$this->getTable()." set ".$model_name."=".$model_name."+1 where id=".$industry_id;
	    }
	    $result = $g_db->Execute($sql);
	    if ($result) {
	    	if ($write) {
	    		$this->recacheIndustryAmount();
	    	}
	    	return true;
	    }else{
	        return false;
	    }
	}

	function recacheIndustryAmount()
	{
	    $fields = "id,name,buy_amount,sell_amount,product_amount,company_amount";
	    $parent_list = $this->findAll($fields, "parentid=0 and if_show_module=1", "priority desc,id asc");
	    $cache_ind = array();
	    foreach ($parent_list as $val) {
	        unset($tmp_subs);
	        $sub_industry = $this->findAll($fields, "parentid=".$val['id']." and if_show_module=1");

	        if (!empty($sub_industry)) {
	            foreach ($sub_industry as $val_s) {
	                $tmp_subs[$val_s['id']] = array("id"=>$val_s['id'], "name"=>$val_s['name'], "amount"=>$val_s['buy_amount']."|".$val_s['sell_amount']."|".$val_s['company_amount']."|".$val_s['product_amount']);
	            }
	        }
	        $cache_ind[$val['id']] = array("id"=>$val['id'], "name"=>$val['name'], "amount"=>$val['buy_amount']."|".$val['sell_amount']."|".$val['company_amount']."|".$val['product_amount'], "subs"=>$tmp_subs);
	    }
	    $cache_ind2 = var_export($cache_ind, true);
	    $fp = fopen(BASE_DIR."data/cache/industry.inc.php", "w+");
	    $cache_ind3 = "<?php \n"."\$"."CACHE_P_INDUSTRY = ".$cache_ind2."\n?>";
	    $write_cache = fwrite($fp, $cache_ind3);
	    fclose($fp);
	    return true;
	}

	function updateCache($filename, $extra = "w")
	{
	    global $g_db, $trade, $tb_prefix;
		$industry_ids = $this->findAll("id AS IndustryId,name AS IndustryName");
		$mysql_v = $this->getMysqlVersion();
		$str = "<?php
\$UL_DBCACHE_INDUSTRIES = array(\n";
		foreach ($industry_ids as $val) {
		    $str.="\"".$val['IndustryId']."\"=>\"".$val['IndustryName']."\",\n";
			if ($mysql_v < 5) {
				$product_amount = $g_db->GetOne("select count(id) from {$tb_prefix}products where  industry_id=".$val['IndustryId']);
				$company_amount = $g_db->GetOne("select count(id) from {$tb_prefix}companies where  industry_id=".$val['IndustryId']);
				$buy_amount = $g_db->GetOne("select count(id) from {$tb_prefix}trades where type_id in ".$trade->getTradeTypeKeys("buy")." and industry_id=".$val['IndustryId']);
				$sell_amount = $g_db->GetOne("select count(id) from {$tb_prefix}trades where type_id in ".$trade->getTradeTypeKeys("sell")." and industry_id=".$val['IndustryId']);
				$sql = "update {$tb_prefix}industries set product_amount='$product_amount',sell_amount='$sell_amount',buy_amount='$buy_amount',company_amount='$company_amount' where id=".$val['IndustryId'];
				$result = $g_db->Execute($sql);
			}else{
				$sql = "update {$tb_prefix}industries set product_amount = (SELECT count(Product.id) from {$tb_prefix}products as Product where Product.industry_id=".$val['IndustryId']."),sell_amount = (SELECT count(Trade.id) FROM {$tb_prefix}trades as Trade where Trade.type_id in ".$trade->getTradeTypeKeys("sell")."  and Trade.industry_id=".$val['IndustryId']."),buy_amount = (SELECT count(Trade.id) FROM {$tb_prefix}trades Trade where Trade.type_id in ".$trade->getTradeTypeKeys("buy")."  and Trade.industry_id=".$val['IndustryId']."),company_amount = (SELECT count(Company.id) FROM {$tb_prefix}companies Company where Company.industry_id=".$val['IndustryId'].") where id=".$val['IndustryId'];
				$g_db->Execute($sql);
			}
		}
		$str.=");\n?>";
		$this->writeCache($filename, $str, $extra);
	}
}
?>