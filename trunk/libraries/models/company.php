<?php
/**
 * NOTE   :  PHP versions 4 and 5
 *
 * PHPB2B :  An Opensource Business To Business E-Commerce Script (http://www.phpb2b.com/)
 * Copyright 2007-2009, Ualink E-Commerce Co,. Ltd.
 *
 * Licensed under The GPL License (http://www.opensource.org/licenses/gpl-license.php)
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * @copyright Copyright 2007-2009, Ualink E-Commerce Co,. Ltd. (http://phpb2b.com)
 * @since PHPB2B v 1.0.0
 * @link http://phpb2b.com
 * @package phpb2b
 * @version $Id$
 */
class Companies extends PbModel {
 	var $name = "Company";
	var $configs = null;
	var $info = null;
	var $id;


 	function Companies()
 	{
 		parent::__construct();
 	}
 	
 	function setInfo($info)
 	{
 		$this->info = $info;
 	}
 	
 	function getInfo()
 	{
 		return $this->info;
 	}
 	
 	function setId($id)
 	{
 		$this->id = $id;
 		$info = null;
 		$info = $this->getInfoById($id);
 		$this->setInfo($info);
 	}
 	
 	function getId()
 	{
 		return $this->id;
 	}
 	
 	function setInfoById($company_id)
 	{
 		$result = array();
 		$sql = "SELECT c.* FROM {$this->table_prefix}companies c WHERE c.id='{$company_id}'";
 		$result = $this->dbstuff->GetRow($sql);
 		$this->info = $result;
 	}
 	
 	function setInfoByMemberId($member_id)
 	{
 		$result = array();
 		$sql = "SELECT * FROM {$this->table_prefix}companies c WHERE c.member_id='{$member_id}'";
 		$result = $this->dbstuff->GetRow($sql);
 		$this->info = $result; 		
 	}
 	
 	function Delete($ids, $conditions = array())
	{
		$condition = array();
		if (is_array($ids)) {
			$condition[] = "id IN (".implode(",", $ids).")";
		}else{
			$condition[] = "id=".$ids;
		}
		$condition = am($condition, $conditions);
		$this->setCondition($condition);
		$this->dbstuff->Execute("DELETE FROM {$this->table_prefix}companies,{$this->table_prefix}companyfields USING {$this->table_prefix}companies LEFT JOIN {$this->table_prefix}companyfields ON {$this->table_prefix}companyfields.company_id={$this->table_prefix}companies.id ".$this->getCondition());
		return true;
	}

	function getCompanyInfo($companyid,$memberid = null)
	{
		$sql = "SELECT * FROM ".$this->getTable(true)." WHERE 1 ";
		if(!is_null($memberid)) $sql.=" AND member_id=".$memberid;
		if(!is_null($companyid)) $sql.=" AND id=".$companyid;
		$res = $this->dbstuff->GetRow($sql);
		return $res;
	}

	function statCompany()
	{
		$sql = "select type_id,count(Company.id) as Amount from ".$this->getTable(true)." group by Company.type_id";
		$return = $this->dbstuff->GetAll($sql);
		foreach ($return as $key=>$val) {
			$m[$val['type_id']] = $val['Amount'];
		}
		if($return) $m['sum'] = array_sum($m);
		return $m;
	}

	function update($posts, $action=null, $id=null, $tbname = null, $conditions = null){
		global $data;
		if(isset($data['Templet']['title'])){
			$cfg['templet_name'] = $data['Templet']['title'];
			$posts['configs'] = serialize($cfg);
		}
		return $this->save($posts, $action, $id, $tbname, $conditions);
	}

	function getTempletName($configs){
		$cfgs = unserialize($configs);
		return $cfgs['templet_name'];
	}

	function setConfigs($configs){
		$cfgs = unserialize($configs);
		$this->configs = $cfg;
	}

	function getConfigs(){
		return $this->configs;
	}

	function checkStatus($company_id)
	{
		$sql = "SELECT status FROM {$this->table_prefix}companies WHERE id=".$company_id;
		$c_status = $this->dbstuff->GetRow($sql);
		if (!$c_status['status'] || empty($c_status['status'])) {
			flash("company_checking_or_invalid", "company.php");
		}
	}
	
	function getInfoById($company_id)
	{
		$sql = "SELECT c.*,c.name as companyname,CONCAT(telcode,'-',telzone,'-',tel) AS link_tel FROM {$this->table_prefix}companies c WHERE c.id={$company_id}";
		$result = $this->dbstuff->GetRow($sql);
		$this->info = $result;
		return $result;
	}
	
	function Add($member_id = -1)
	{
		global $companyfield, $default_membergroupid;
		if (empty($this->params['data']['company']['name'])) {
			return false;
		}
		$this->params['data']['company']['member_id'] = $member_id;
		$this->params['data']['company']['created'] = $this->params['data']['company']['modified'] = $this->timestamp;
		$this->params['data']['company']['cache_spacename'] = $this->timestamp;
		$this->params['data']['company']['cache_membergroupid'] = $default_membergroupid;
		$this->save($this->params['data']['company']);
		$key = $this->table_name."_id";
		$last_companyid = $this->$key;
		$companyfield->primaryKey = "company_id";
		$companyfield->params['data']['companyfield']['company_id'] = $last_companyid;
		$companyfield->save($companyfield->params['data']['companyfield']);
		return true;
	}
	
	function checkNameExists($company_name)
	{
		$result = $this->field("id", "name='".$company_name."'");
		if (empty($result) || !$result) {
			return false;
		}else{
			return true;
		}
	}
	
	function updateCachename($id, $new_name)
	{
		$old_name = $this->dbstuff->GetOne("SELECT name FROM {$this->table_prefix}companies WHERE id=".$id);
		if (pb_strcomp($old_name, $new_name)) {
			return;
		}
		$this->dbstuff->Execute("UPDATE {$this->table_prefix}products p SET p.cache_companyname='".$new_name."' WHERE p.company_id=".$id);
		$this->dbstuff->Execute("UPDATE {$this->table_prefix}trades t SET t.cache_companyname='".$new_name."' WHERE t.company_id=".$id);
	}
	
	function formatResult($result)
	{
		global $_PB_CACHE;
		if (!$result || empty($result)) {
			return null;
		}
		if (!isset($_PB_CACHE['membergroup'])) {
			require(CACHE_PATH. "cache_membergroup.php");
		}
		if (!isset($_PB_CACHE['manage_type'])) {
			require(CACHE_PATH. "type_manage_type.php");
		}
		$count = count($result);
		for ($i=0; $i<$count; $i++){
			$result[$i]['gradeimg'] = 'images/group/'.$_PB_CACHE['membergroup'][$result[$i]['cache_membergroupid']]['avatar'];
			$result[$i]['managetype'] = $_PB_CACHE['manage_type'][$result[$i]['manage_type']];
			if(isset($result[$i]['membergroup_id'])) $result[$i]['gradename'] = $_PB_CACHE['membergroup'][$result[$i]['membergroup_id']]['name'];
			if (isset($result[$i]['space_name'])) {
				$result[$i]['url'] = "space.php?userid=".$result[$i]['space_name'];
			}else{
				$result[$i]['url'] = "javascript:;";
			}
			if (isset($result[$i]['picture'])) {
				$result[$i]['logo'] = pb_get_attachmenturl($result[$i]['picture'], '', 'small');
			}
		}
		return $result;		
	}
}
?>