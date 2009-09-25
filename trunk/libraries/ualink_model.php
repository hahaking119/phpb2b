<?php
/**
 * Note : The Software shall be used for Good, not Evil.
 * PHPB2B - As an open source b2b program.
 *
 * Permission is hereby granted to use this version of the library under the
 * following license:
 *
 * --
 * Copyright (c) 2006-2009 Ualink (http://www.phpb2b.com/)
 *
 * All rights granted under this License are granted for the term of copyright on
 * the Program, and are irrevocable provided the stated conditions are met. This
 * License explicitly affirms your unlimited permission to run the unmodified Program.
 * The output from running a covered work is covered by this License only if the
 * output, given its content, constitutes a covered work.
 * This License acknowledges your rights of fair use or other equivalent, as provided
 * by copyright law.
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * --
 *
 * @package phpb2b
 * @subpackage app.libs
 * @copyright 2009 PHPB2B <phpb2b@hotmail.com> (http://www.phpb2b.com/)
 * @license http://www.opensource.org/licenses/gpl-license.php GPL License
 * @created Mon Jun 22 16:07:36 CST 2009
 * @link http://sourceforge.net/projects/php-b2b/
 * @version $Id: ualink_model.php 25 2009-08-28 01:46:55Z stevenchow811@163.com $
 */
class UaModel extends UaObject
{
	var $primaryKey = "id";
	var $id = null;
	var $catchIds = null;
	var $table;
	var $col = 0;
	var $row = 1;
	var $limit_max = 10;
	var $title;
	var $position;
	/**
	* if your site is made by div
	* you can change this like to </div><div>.
	*/
	var $term = "</tr><tr>";
	/**
	 * If your site is made by li
	 * you can change this like to </div>
	 * @var unknown_type
	 */
	var $line_term = "</tr>";
    /**
     * Trades
     *
     * @var unknown_type
     */
 	var $offer_expires = array("10"=>"10天","30"=>"一个月","90"=>"三个月","180"=>"六个月");
	var $buy_types = array("1"=>"求购", "4"=>"合作", "5"=>"招商");
	var $sell_types = array("2"=>"供应", "3"=>"代理", "6"=>"加盟", "7"=>"批发", "8"=>"库存");
 	var $params = array(
 	"1"=>array("title"=>"产品数量", "name"=>"quantity", "size"=>"10", "max_length"=>10),
 	"2"=>array("title"=>"包装说明", "name"=>"package", "size"=>"10", "max_length"=>100),
 	"3"=>array("title"=>"价格说明", "name"=>"price", "size"=>"10", "max_length"=>50),
 	"4"=>array("title"=>"产品规格", "name"=>"scale", "size"=>"10", "max_length"=>20),
 	"5"=>array("title"=>"产品编号", "name"=>"sn", "size"=>"10", "max_length"=>20),
 	);
 	/**
 	 * Company
 	 */
 	var $manage_type = array(1=>"生产型",2=>"贸易型",3=>"服务型",4=>"政府或其他机构");
 	var $main_market = array(1=>"大陆", 2=>"港澳台", 3=>"北美", 4=>"南美", 5=>"欧洲",6=>"亚洲", 7=>"非洲", 8=>"大洋洲",9=>"其他市场");
 	var $company_funds = array(
		0=>"**不公开**",1=>"人民币 10万元之下",
		2=>"人民币 10万-30万",3=>"人民币 30万-50万",
		4=>"人民币 50万-100万",5=>"人民币 100万-300万",
		6=>"人民币 300万-500万",7=>"人民币 500万-1000万",
		8=>"人民币 1000 万元/年-5000 万元/年",9=>"人民币 5000 万元/年-1 亿元/年",
		9=>"其他",
		);
 	var $year_annuals = array(
		0=>"**不公开**",1=>"人民币 10万元之下/年",
		2=>"人民币 10万-30万/年",3=>"人民币 30万-50万/年",
		4=>"人民币 50万-100万/年",5=>"人民币 100万-300万/年",
		6=>"人民币 300万-500万/年",7=>"人民币 500万-1000万/年",
		8=>"人民币 1000万-5000万/年",9=>"人民币 5000万以上/年",
		9=>"其他",
		);
	var $economic_type = array("请选择","国有企业",
		"集体企业",
		"股份合作企业",
		"联营企业",
		"国有联营企业",
		"集体联营企业",
		"国有与集体联营企业",
		"其他联营企业",
		"有限责任公司",
		"国有独资的有限责任公司",
		"其他有限责任公司",
		"股份有限公司",
		"私营企业",
		"私营独资企业",
		"私营合作企业",
		"私营有限责任公司",
		"私营股份有限公司",
		"个人独资企业",
		"与港、澳、台商合资经营企业",
		"与港、澳、台商合作经营企业",
		"港、澳、台商独资经营企业",
		"港、澳、台商投资股份有限公司",
		"中外合资经营企业",
		"中外合作经营企业",
		"外商独资企业",
		"外商投资股份有限公司",
		"非盈利组织",
		"其他",
		);
	var $company_status = array("0"=>"无效","1"=>"有效","2"=>"等待审核","3"=>"审核不通过");
	var $employee_amount = array(
	0=>"**不公开**",
	1=>"5 人以下",2=>"5 - 10 人",3=>"11 - 50 人",4=>"51 - 100 人",5=>"101 -500 人",6=>"501- 1000 人",7=>"1000 人以上");
    /**
     * Service
     */
 	var $status = array("0"=>"无效","1"=>"有效");
 	var $types = array("1"=>"咨询","2"=>"建议","3"=>"投诉");
 	/**
 	 * Orders
 	 */
 	var $order_status = array(0=>"正在审核",1=>"审核通过",2=>"审核失败");
    /**
     * Job
     */
	var $educations = array(
		0=>"不限",
		1=>"博士",
		2 =>"MBA",
		3 =>"硕士",
		4 =>"本科",
		5 =>"大专",
		6 =>"中专",
		7 =>"中技",
		8 =>"高中",
		9 =>"初中",
		10 =>"小学",
		11=>"其他",
		);
	var $salary = array('0'=>'面议','1'=>'1500以下','2'=>'1500-1999元','3'=>'2000-2999','4'=>'3000-4499元','5'=>'4500-5999元','6'=>'6000-7999元','7'=>'8000-9999元','8'=>'10000-14999元','9'=>'15000-19999元','10'=>'20000-29999元','11'=>'30000-49999元','12'=>'50000元以上');
	var $worktype = array('1'=>"全职",'2'=>"兼职",'3'=>"临时",'4'=>"实习",'5'=>"其他");
    /**
     * Member
     */
 	var $ua_positions = array(0=>"请选择",1=>"董事长、总裁及副职，企业主、企业合伙人，总经理/副总经理",
 	2=>"行政部门经理/行政人员",3=>"技术部门经理/技术人员",4=>"生产部门经理/生产人员",
 	5=>"市场部门经理/市场人员",6=>"采购部门经理/采购人员",7=>"销售部门经理/销售人员",8=>"其他",
 	);
 	var $ua_member_types = array(0=>"会员类型",1=>"免费企业会员",2=>"收费企业会员");
	var $genders = array("1"=>"先生","2"=>"女士","0"=>"保密");
 	var $member_status = array("0"=>"无效","1"=>"有效","2"=>"等待审核","3"=>"审核不通过","4"=>"被禁用");
 	var $im_types = array("1"=>"QQ","2"=>"ICQ","3"=>"Msn Messenger","4"=>"Yahoo Messenger","5"=>"Skype");
 	var $phone_types = array("1"=>"移动电话","2"=>"住宅电话","3"=>"商务电话","4"=>"其他电话");
	var $office_redirects = array("返回上一页", "网站首页", "商务室首页", "我的供求信息", "我收到的留言");

	function setPageTitle($titles = null, $positions = null, $left = "&laquo;", $right = "&raquo;")
	{
	    global $_SETTINGS;
	    if(is_array($titles)) {
	        $titles[] = $_SETTINGS['sitetitle'];
	        $title = implode($left, $titles);
	    }
		else $title = $titles;
		$this->title = $title;
	    if(is_array($positions)) {
	        $positions[] = $_SETTINGS['sitename'];
	        rsort($positions);
	        $position = implode($right, $positions);
	    }
		else $position = $positions;
		$this->position = $position;
	}

	function getTitle()
	{
		return $this->title;
	}

	function getPosition()
	{
		return $this->position;
	}


	function checkTerminal($i)
	{
	    $col = $this->col;
	    if($this->col>0){
	        if ($col==$this->limit_max) {
	        	return "";
	        }else{
	        if($i%$col==0){
	           return $this->term;
	        }else{
	            return "";
	        }
	        }
	    }elseif($this->row==1){
	        return $this->line_term;
	    }else{
	        return "";
	    }
	}

	function setLimit($row, $col, $max)
	{
	    if (!empty($max)) {
	    	$this->limit_max = $max;
	    }
	    if ($row>1) {
	    	$this->row = $row;
	    }
	    if ($col>0) {
	    	$this->col = $col;
	    }
	}

	function getLimit()
	{
	    if ($this->col==0 || $this->row==1) {
	    	$return  = " limit ".$this->limit_max;
	    }else{
	        $return = " limit ".$this->col*$this->row;
	    }
	    return $return;
	}

	function setPrimaryKey($p = null)
	{
		if (is_null($p)) {
			$p = "id";
		}
		$this->primaryKey = $p;
	}

	function getPrimaryKey()
	{
		return $this->primaryKey;
	}

	function setId($id)
	{
		$this->id = $id;
	}

	function getId()
	{
		return $this->id;
	}

	/**
	 * 代替旧版本1.0的delete
	 * @param Mixed $id_array 要删除的唯一ID，数组或者整数
	 * @return Boolean
	 */
	function del($id_array, $conditions = null)
	{
		global $g_db;
		$del_id = $this->primaryKey;
		$tmp_ids = null;
		if (is_array($id_array))
		{
			$tmp_ids = implode(",",$id_array);
			$cond[] = "$del_id in (".$tmp_ids.")";
			$this->catchIds = serialize($id_array);
		}
		else
		{
			$cond[] = "$del_id=".intval($id_array);
			$this->catchIds = $id_array;
		}
		if(isset($conditions)) {
			if(is_array($conditions)) $cond[] = implode(" and ", $conditions);
			else $cond[] = $conditions;
		}
		$tmp_where_cond = implode(" and ", $cond);
		$sql = "delete from ".$this->getTable()." where ".$tmp_where_cond;
		$r_deleted = $g_db->Execute($sql);
		if($r_deleted)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * 代替旧版本的update
	 * 2007-8-28 以this->primaryKey代替旧有的固定 id字段，使得可以自由选择。
	 */
	function save($posts, $action=null, $id=null, $tbname = null, $conditions = null, $if_check_word_ban = false)
	{
		global $g_db;
		global $primary_id;
		$new_id = false;
		$keys = array_keys($posts);
		$cols = implode($keys,",");
		$tbname = (is_null($tbname))? $this->getTable():trim($tbname);
		if(!empty($primary_id)){
			$sql = "select $cols from ".$tbname." where ".$this->primaryKey."='".$primary_id."'";
		}elseif(!empty($id)){
			$sql = "select $cols from ".$tbname." where ".$this->primaryKey."='".$id."'";
		}else{
			$sql = "select $cols from ".$tbname." where ".$this->primaryKey."='-1'";
		}
		if (!is_null($conditions)) {
			$sql.= $conditions;
		}
		$rs = $g_db->Execute($sql);
		$record = array();
		foreach ($keys as $colname) {
			$record[$colname] = $posts[$colname];
			if($if_check_word_ban){
				//check mask words.
			}
		}
		if (strtolower($action) == "update" || !empty($primary_id)) {
			$insertsql = $g_db->GetUpdateSQL($rs,$record);
		}else {
		    $new_id = true;
			$insertsql = $g_db->GetInsertSQL($rs,$record);
		}
		$result = $g_db->Execute($insertsql);
		if (!$result || empty($result)) {
			return false;
		}else {
		    if($new_id){
		        $insert_key = $tbname."_id";
		        $this->$insert_key = $g_db->Insert_ID();
		    }
			return true;
		}
	}

	/**
	 * 得到某条记录的信息
	 *
	 * @param unknown_type $id
	 */
	function read($fields = null, $id = null, $tables = null, $conditions = null)
	{
		global $g_db;
		global $joins;
		$tmp_tablename = null;
		if ($id!==null) {
			$this->id = $id;
		}
		$id = $this->id;
		if (is_array($this->id)) {
			$id = $this->id[0];
		}
		if($tables == null){
			$tmp_tablename = $this->getTable(true);
		}
		if (is_null($fields)) {
			$fields = null;
			$columns = $g_db->MetaColumnNames($this->getTable());
			foreach ($columns as $key=>$val) {
				$fields.=$key." as ".$this->name.pb_format_column($val).",";
			}
			$fields = substr_replace($fields,'',-1,1);
		}
		$sql = null;

		if ($this->id !== null && $this->id !== false) {
			$field = trim($this->name).".".$this->primaryKey;
		}
		$sql = "select ".$fields." from ".$tmp_tablename." where ".$field."='".$id."'";
		if($conditions !=null){
			$sql.= " ".$conditions;
		}
		$res = $g_db->GetRow($sql);
		return $res;
	}

	/**
	 * 得到某个field的值，类似adodb的getone
	 * 2.0用field代替
	 * @param 字段值 $target_val
	 * @param 要得到字段值的字段名称 $get_col
	 * @param 字段名 $target_col
	 * @return unknown
	 */
	function find($target_val,$get_col = "id", $target_col=null)
	{
		global $g_db;
		if(is_null($target_col)) $target_col = $this->primaryKey;
		$sql = "select ".$get_col." from ".$this->getTable(true)." where ".$target_col."='".$target_val."'";
		$res  = $g_db->GetOne($sql);
		return $res;
	}

	/**
	 * 根据条件，得到某一个字段的名称
	 * 代替1.0的find函数
	 * @param 字段名称 $name
	 * @param 条件 $conditions
	 * @param 排序 $order
	 * @return 字段值
	 */
	function field($name, $conditions = null, $order = null) {
		global $g_db;

		if ($conditions === null) {
			$conditions = array($this->name . '.' . $this->primaryKey => $this->id);
		}
		if (is_array($conditions)) {
			$tmp_conditions = implode(" and ",$conditions);
			$conditions = $tmp_conditions;
		}
		$sql = "select ".trim($name)." from ".$this->getTable(true)." where ".$conditions;
		$result  = $g_db->GetOne($sql);
		return $result;
	}

	function getFieldAliasNames()
	{
		global $g_db;
		$table_name = $this->getTable();
		$fields = null;
		$columns = $g_db->MetaColumnNames($table_name);
		foreach ($columns as $key=>$val) {
			$fields.=$this->name.".".$key." as ".$this->name.pb_format_column($val).",";
		}
		$fields = substr_replace($fields,'',-1,1);
		return $fields;
	}

	/**
	 * 代替1.0beta的getTableName();
	 *
	 * @param 是否同时取得别名 $alias
	 * @return 数据表（别）名
	 */
	function getTable($alias = false)
	{
		global $tb_prefix;
		$table = $tb_prefix.strtolower(get_class($this));
		if($alias) $table.= " as ".$this->name;
		return $table;
	}

	/**
	 * 代替1.0的 getAmount
	 *
	 * @param unknown_type $conditions
	 * @param unknown_type $countfield
	 * @return unknown
	 */
	function findCount($conditions = null, $countfield = null, $tables = null, $ujoins="")
	{
		global $g_db;
		global $joins;
		$tmp_conditions = null;
		$sql = null;
		if(is_null($countfield)) $countfield = $this->primaryKey;
		if (is_null($tables)) {
			$tables = $this->getTable(true);
		}
		if (!empty($joins)) {
			foreach ($joins as $assoc => $data) {
				$tables.=",".$data['fullTableName'];
				$tmp_conditions.= "and ".$this->name.".".$data['foreignKey']."=".$assoc.".id";
			}
		}
		$sql = "select count(".$countfield.") as Amount from ".$tables." ".$ujoins;
		if (!empty($conditions)) {
			$sql.= " where ".$conditions." ".$tmp_conditions;
		}
		$return = $g_db->GetOne($sql);
		return $return;
	}

	/**
	 * 代替所有的 getRecords,综合left join,belongsto
	 *
	 * @param unknown_type $fields
	 * @param unknown_type $conditions
	 * @param unknown_type $order
	 * @param unknown_type $limit
	 * @param unknown_type $offset
	 * @param unknown_type $recursive
	 * @return unknown
	 */
	function findAll($fields, $conditions = null, $order = null, $limit = null, $offset = null, $recursive = null)
	{
		global $g_db;
		global $joins;
		$join_fields	= null;
		$orders			= null;
		$records		= null;
		$condition	 	= null;
		if (!empty($joins)) {
			foreach ($joins as $assoc => $data) {
				if(isset($data['foreignKey'])) {
					if(isset($data['PrimaryKey'])) $values[] = " left join ".$data['fullTableName']." on ".$assoc.".".$data['PrimaryKey']."=".$this->name.".".$data['foreignKey'];
					else $values[] = " left join ".$data['fullTableName']." on ".$this->name.".".$data['foreignKey']."=".$assoc.".id ";
				}else $values[] = " left join ".$data['fullTableName']." on ".$this->name.".".$data['foreignKey']."=".$assoc.".id ";
				if($data['fields']) $find_fields[] = $data['fields'];
			}
			$join_fields = implode(" ",$values);
		}

		if (is_null($fields)) {
			$find_fields[] = $this->name.".*";
		}else{
			$find_fields[] = $fields;
		}
		$fields = implode(",",$find_fields);
		$sql = "select ".$fields." from ".$this->getTable(true).$join_fields;
		if (!empty($conditions)) {
			$condition.= " where ".$conditions;
			$sql.= $condition;
		}
		if (!is_null($order)) {
			$orders.= " order by ".$order;
			$sql.= $orders;
		}
		if (!is_null($limit) && !is_null($offset)) {
			$records.= " limit $limit,$offset";
			$sql.=$records;
		}
		$return = $g_db->GetArray($sql);
		return $return;
	}

	function clicked($id, $add = true)
	{
		global $g_db;
		if($add){
			$sql = "update ".$this->getTable()." set clicked=clicked+1 where id=".$id;
		}
		return $g_db->Execute($sql);
	}

	/**
	 * 修改记录的状态
	 *
	 * @param mixed 要修改的编号 $id
	 * @param 修改为状态 $status
	 * @return boolean
	 */
	 function check($id = null, $status = 0)
	{
		if(is_array($id)){
			$checkId = "id in (".implode(",",$id).")";
		}elseif(intval($id)) {
			$checkId = "id=".$id;
		}else{
			return false;
		}
		$sql = "update ".$this->getTable()." set status='".$status."' where ".$checkId;
		$return = $GLOBALS['g_db']->Execute($sql);
		if($return){
			return true;
		}else {
			return false;
		}
	}

	/**
	 * 更新某个字段
	 * @param mixed 字段名称
	 * @param mixed 新值
	 * @return boolean
	 */
	function saveField($name, $value, $id = null, $conditions = null)
	{
		if(is_array($id)){
			$checkId = "id in (".implode(",",$id).")";
		}elseif(is_int($id)) {
			$checkId = "id=".$id;
		}else{
			$checkId = 1;
		}
		if(empty($conditions)) $conditions = 1;
		if($checkId){
			$sql = "update ".$this->getTable()." set $name='".$value."' where ".$checkId." and ".$conditions;
			$return = $GLOBALS['g_db']->Execute($sql);
		}
		return $return;
	}

	/**
	 * 返回某个表中最大的id，可以表示为最后插入的id号
	 *
	 * @return unknown
	 */
	function getMaxId()
	{
		$sql = "select max(id) from ".$this->getTable();
		$max_id = $GLOBALS['g_db']->GetOne($sql);
		return $max_id;
	}
}
?>