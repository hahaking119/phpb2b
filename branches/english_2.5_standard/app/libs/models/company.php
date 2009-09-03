<?php
 class Companies extends UaModel {
 	var $name = "Company";
	var $common_cols = "Company.id AS ID, AS MemberID,industry_id AS CompanyIndustryId,style_id AS Style,Company.name AS CompanyName,Company.description AS Description,main_prod AS MainProduct,boss_name AS Leader,tel AS Tel,mobile AS MobilePhone,link_man AS Linker,fax AS Fax,found_date AS FoundDate,email AS CompanyEmail,Company.*";
	var $alias_cols = "CONCAT(telcode,'-',telzone,'-',tel) AS MixTel,CONCAT(faxcode,'-',faxzone,'-',fax) AS MixFax";
	var $menu = null;
	var $configs = null;


 	function Companies()
 	{
 		//$this->setTableName($GLOBALS['tb_prefix'].$this->table_name);
 	}

	function getCompanyInfo($companyid,$memberid = null,$cols = null)
	{
		$sql = "select ";
		if(empty($cols))
		$sql.= $this->common_cols;
		else
		$sql.= $cols;
		$sql.= " from ".$this->getTable(true)." where 1 ";
		if(!is_null($memberid)) $sql.=" and member_id=".$memberid;
		if(!is_null($companyid)) $sql.=" and id=".$companyid;
		$res = $GLOBALS['g_db']->GetRow($sql);
		return $res;
	}

	function statCompany()
	{
		$sql = "select type_id,count(Company.id) as Amount from ".$this->getTable(true)." group by Company.type_id";
		$return = $GLOBALS['g_db']->GetAll($sql);
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

	function getConifigs(){
		return $this->configs;
	}

	function setMenu($pretend_level){
		global $_GET, $config_subdomain, $subdomain_support, $userid;
		$tmp_host = uaGetHost(false);
		$tmp_menus = array();
		if($subdomain_support){
		    $user_id = $userid; // From member-index.php
    		$tmp_menus['index'] = "http://".$user_id.$config_subdomain."/";
    		$tmp_menus['intro'] = "http://".$user_id.$config_subdomain."/intro/";
    		$tmp_menus['product'] = "http://".$user_id.$config_subdomain."/product/";
    		$tmp_menus['trade'] = "http://".$user_id.$config_subdomain."/trade/";
    		$tmp_menus['news'] = "http://".$user_id.$config_subdomain."/news/";
    		$tmp_menus['honour'] = "http://".$user_id.$config_subdomain."/honour/";
    		$tmp_menus['hr'] = "http://".$user_id.$config_subdomain."/hr/";
    		$tmp_menus['contact'] = "http://".$user_id.$config_subdomain."/contact/";
    		$tmp_menus['feedback'] = "http://".$user_id.$config_subdomain."/feedback/";
		}else{
		    if (isset($_GET['userid'])) {

		        $user_id = $_GET['userid'];
		        $tmp_menus['index'] = URL."space.php?do=home&userid=".$user_id;
		        $tmp_menus['intro'] = URL."space.php?do=intro&userid=".$user_id;
		        $tmp_menus['product'] = URL."space.php?do=product&userid=".$user_id;
		        $tmp_menus['trade'] = URL."space.php?do=trade&userid=".$user_id;
		        $tmp_menus['news'] = URL."space.php?do=news&userid=".$user_id;
		        $tmp_menus['honour'] = URL."space.php?do=honour&userid=".$user_id;
		        $tmp_menus['hr'] = URL."space.php?do=hr&userid=".$user_id;
		        $tmp_menus['contact'] = URL."space.php?do=contact&userid=".$user_id;
		        $tmp_menus['feedback'] = URL."space.php?do=feedback&userid=".$user_id;
		    }elseif (isset($_GET['id'])){
		        $user_id = intval($_GET['id']);
		        $tmp_menus['index'] = URL."space.php?do=home&id=".$user_id;
		        $tmp_menus['intro'] = URL."space.php?do=intro&id=".$user_id;
		        $tmp_menus['product'] = URL."space.php?do=product&id=".$user_id;
		        $tmp_menus['trade'] = URL."space.php?do=trade&id=".$user_id;
		        $tmp_menus['news'] = URL."space.php?do=news&id=".$user_id;
		        $tmp_menus['honour'] = URL."space.php?do=honour&id=".$user_id;
		        $tmp_menus['hr'] = URL."space.php?do=hr&id=".$user_id;
		        $tmp_menus['contact'] = URL."space.php?do=contact&id=".$user_id;
		        $tmp_menus['feedback'] = URL."space.php?do=feedback&id=".$user_id;
		    }
		}
		$this->menu = $tmp_menus;
	}

	function getMenu(){
		return $this->menu;
	}

	function checkStatus($company_id)
	{
		global $g_db, $tb_prefix;
		$sql = "select status,name from ".$tb_prefix."companies where id=".$company_id;
		$c_status = $g_db->GetRow($sql);
		if (!$c_status['status'] || empty($c_status['status'])) {
			flash(URL."room/tip.php", "./", sprintf(lgg("company_checking"), $c_status['name']), 0);
		}
	}
}
?>