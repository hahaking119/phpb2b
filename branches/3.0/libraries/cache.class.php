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
 * @version $Id: cache.class.php 481 2009-12-28 01:05:06Z steven $
 */
class Caches extends PbObject {
	var $cache_name = null;
	
	function Caches($cache_name = null)
	{
		if (!empty($cache_name)) {
			$this->cache_name = $cache_name;
		}
	}
	
	function updateSettings() {
		global $_PB_CACHE;
		if(isset($_PB_CACHE['setting']) && is_array($_PB_CACHE['setting'])) {
			writeCache('setting', '', '$_PB_CACHE[\'setting\'] = '.evalArray($_PB_CACHE['setting']).";\n\n");
		}
	}
	
	function updateAgreement($data)
	{
		global $_PB_CACHE;
		if (!empty($data)) {
			$op = str_replace(array("%site_name%","%site_url%"), array($_PB_CACHE['setting']['site_name'], $_PB_CACHE['setting']['site_url']), $data);
			return file_put_contents(CACHE_PATH. "cache_agreement.php", $op);
		}else{
			return false;
		}
	}
	
	function updateTypevars()
	{
		global $pdb, $tb_prefix;
		$cur_data = $type_js_data = null;
		$sql = "SELECT id,type_name FROM {$tb_prefix}typemodels tm";
		$Typemodels = $pdb->GetArray($sql);
		$type_js_data = "<!--// Created ".date("M j, Y, G:i")." \n";
		if (!empty($Typemodels)) {
			foreach ($Typemodels as $key=>$val) {
				$data = array();
				$tmp_js_option = null;
				$tmp_options = $pdb->GetArray("SELECT option_value,option_label FROM {$tb_prefix}typeoptions WHERE typemodel_id=".$val['id']);
				$type_js_data.="var ".$val['type_name']." = [";
				if (!empty($tmp_options)) {
					foreach ($tmp_options as $option_key=>$option_val) {
						$tmp_js_option[] = "['".$option_val['option_label']."','".$option_val['option_value']."']";
						$data[$option_val['option_value']] = $option_val['option_label'];
					}
				}
				$tmp_js = implode(",", $tmp_js_option);
				$type_js_data.=$tmp_js."];\n";
				$cachename = $val['type_name'];
				$cur_data = "\$_PB_CACHE['$cachename'] = ".$this->evalArray($data).";\n\n";
				$this->writeCache($cachename, '', $cur_data, 'type_');
			}
			$type_js_data.="//-->";
			include(LIB_PATH. "jsmin.class.php");
			file_put_contents(CACHE_PATH. "type.js", $type_js_data);
			$jsMin = new JSMin(file_get_contents(CACHE_PATH. "type.js"), false);
			$out = $jsMin->minify();
			file_put_contents(CACHE_PATH. "type.js", $out);
		}
	}
	
	function evalArray($array, $level = 0) {
		if(!is_array($array)) {
			return "'".$array."'";
		}
		if(is_array($array) && function_exists('var_export')) {
			return var_export($array, true);
		}
	
		$space = '';
		for($i = 0; $i <= $level; $i++) {
			$space .= "\t";
		}
		$evaluate = "Array\n$space(\n";
		$comma = $space;
		if(is_array($array)) {
			foreach($array as $key => $val) {
				$key = is_string($key) ? '\''.addcslashes($key, '\'\\').'\'' : $key;
				$val = !is_array($val) && (!preg_match("/^\-?[1-9]\d*$/", $val) || strlen($val) > 12) ? '\''.addcslashes($val, '\'\\').'\'' : $val;
				if(is_array($val)) {
					$evaluate .= "$comma$key => ".evalArray($val, $level + 1);
				} else {
					$evaluate .= "$comma$key => $val";
				}
				$comma = ",\n$space";
			}
		}
		$evaluate .= "\n$space)";
		return $evaluate;
	}
	
	function writeCache($script, $cachenames = '', $cachedata = '', $prefix = 'cache_') {
		global $phpb2b_auth_key;
		$mod_label = "Created";
		if (!empty($cachenames)) {
			if(is_array($cachenames) && !$cachedata) {
				foreach($cachenames as $name) {
					$cachedata .= $this->getCacheArray($name, $script);
				}
			}else{
				$cachedata.= $this->getCacheArray($cachenames);
			}
		}
		$dir = PHPB2B_ROOT.'data'.DS.'cache'.DS;
		if(!is_dir($dir)) {
			pb_create_folder($dir);
		}
		$file_name = $dir.$prefix.$script.".php";
		if(file_exists($file_name)) {
			$mod_label = "Modified";
		}
		$fpc = file_put_contents($file_name, "<?php\n/**\n * PHPB2B cache file, DO NOT change me!".
				"\n * {$mod_label}: ".date("M j, Y, G:i").
				"\n * Id: ".md5($prefix.$script.'.php'.$cachedata.$phpb2b_auth_key)."\n */\n\n$cachedata\n?>");
		if(!$fpc) {
			exit(L("write_file_error_and_retry"));
		}
	}	
	
	function getCacheArray($cachename = '', $script = '') {
		global $pdb, $tb_prefix;
		$conditions = $curdata = '';
		$data = array();
		if (empty($cachename) && !empty($this->cache_name)) {
			$cachename = $this->cache_name;
		}
		switch($cachename) {
			case 'setting':
				$tmp_mail = array();
				$table = 'setting';
				$conditions = "";
				$sql = "SELECT * FROM {$tb_prefix}settings";
				$setting = $pdb->GetArray($sql);
				foreach ($setting as $key=>$val) {
					$data[$val['variable']] = $val['valued'];
				}
				//set sendmail
				$tmp_mail['send_mail'] = $data['send_mail'];
				$tmp_mail['smtp_server'] = $data['smtp_server'];
				$tmp_mail['smtp_port'] = $data['smtp_port'];
				$tmp_mail['smtp_auth'] = $data['smtp_auth'];
				$tmp_mail['mail_from'] = $data['mail_from'];
				$tmp_mail['mail_fromwho'] = $data['mail_fromwho'];
				$tmp_mail['auth_username'] = $data['auth_username'];
				$tmp_mail['auth_password'] = $data['auth_password'];
				$tmp_mail['mail_delimiter'] = $data['mail_delimiter'];
				$tmp_mail['sendmail_silent'] = $data['sendmail_silent'];
				$data['mail'] = serialize($tmp_mail);
				unset($tmp_mail,$data['send_mail'],$data['smtp_server'],$data['smtp_port'],$data['smtp_auth'],$data['mail_from'],$data['mail_fromwho'],$data['auth_username'],$data['auth_password'],$data['mail_delimiter'],$data['sendmail_silent']);
				$navs = $pdb->GetArray("SELECT id,name,description,url,target,display_order,highlight FROM {$tb_prefix}navs  WHERE status=1 ORDER BY display_order ASC");
				$data['capt_auth'] = bindec($data['capt_logging'].$data['capt_register'].$data['capt_post_free'].$data['capt_add_market'].$data['capt_login_admin'].$data['capt_apply_friendlink'].$data['capt_service']);
				unset($data['capt_logging'],$data['capt_register'],$data['capt_post_free'],$data['capt_add_market'],$data['capt_login_admin'],$data['capt_apply_friendlink'],$data['capt_service']);
				$navmns = array();
				if (!empty($navs)) {
					foreach ($navs as $nav=>$nav_val) {
						$navmns[$nav_val['id']]['nav'] = '<a href="'.$nav_val['url'].'" title="'.$nav_val['name'].'"'.parse_highlight($nav_val['highlight']).' id="mn_'.$nav_val['id'].'">'.$nav_val['name'].'</a>';
						$navmns[$nav_val['id']]['level'] = $nav_val['display_order'];
					}
					$data['navs'] = $navmns;
				}
				$curdata = "\$_PB_CACHE['$cachename'] = ".$this->evalArray($data).";\n\n";
			break;
			case 'area':
				$sql = "select name,id from {$tb_prefix}areas a where a.parent_id=0";
				$top_areas = $sec_areas = $third_areas = $areas = $total_areas = array();
				$area1 = $pdb->GetArray($sql);
				$op = "<!--// Created ".date("M j, Y, G:i")." -->\n";
				$op .= "var data_area = { \n";
				foreach($area1 as $key=>$val){
					$top_areas[$val['id']] = $total_areas[1][$val['id']] = $val['name'];
					$sql = "select id,name,parent_id ,top_parentid from {$tb_prefix}areas a where level=2 AND parent_id=".$val['id'];
					$sec_areas = $pdb->GetArray($sql);
					foreach($sec_areas as $key2=>$val2){
						$third_areas = $pdb->GetArray("select id,name,parent_id,top_parentid from {$tb_prefix}areas a where level=3 AND parent_id=".$val2['id']);
						$areas[$val['id']]['sub'][$val2['id']] = $val2['name'];
						$total_areas[2][$val2['id']] = $val2['name'];
						foreach($third_areas as $key3=>$val3){
							$areas[$val2['id']]['sub'][$val3['id']] = $total_areas[3][$val3['id']] = $val3['name'];
						}
					}
				}
				$top_areas = $this->convert2utf8($top_areas);
				$areas = $this->convert2utf8($areas);
				$op .= "'0':".json_encode($top_areas);
				$tmp_op = array();
				foreach ($top_areas as $js_key=>$js_val){
					if(isset($areas[$js_key])){
						foreach ($areas[$js_key] as $js_key1=>$js_val1) {
							$tmp_op[] = "'0,{$js_key}':".json_encode($areas[$js_key]['sub']);
							foreach ($areas[$js_key]['sub'] as $js_key2=>$js_val2) {
								if(!empty($areas[$js_key2]['sub'])) $tmp_op[] = "'0,{$js_key},{$js_key2}':".json_encode($areas[$js_key2]['sub']);
							}
						}
					}
				}
			if (!empty($tmp_op)) {
					$op .=",\n";
					$tmp_op = implode(",\n", $tmp_op);
					$op .= $tmp_op."\n}";
				}else{
					$op .= "\n}";
				}
				$fp = file_put_contents(CACHE_PATH. "area.js", $op);
				ksort($total_areas);
				$curdata = "\$_PB_CACHE['$cachename'] = ".$this->evalArray($total_areas).";\n\n";
			break;
			case 'industry':
				$sql = "select name,id from {$tb_prefix}industries i where i.parent_id=0";
				$top_levels = $sec_levels = $third_levels = $datas = $total_datas = array();
				$level1 = $pdb->GetArray($sql);
				$op = "<!--// Created ".date("M j, Y, G:i")." -->\n";
				$op .= "var data_industry = { \n";
				foreach($level1 as $key=>$val){
					$top_levels[$val['id']] = $total_datas[1][$val['id']] = $val['name'];
					$sql = "SELECT id,name,parent_id ,top_parentid FROM {$tb_prefix}industries t where available=1 AND level=2 AND parent_id=".$val['id'];
					$sec_levels = $pdb->GetArray($sql);
					foreach($sec_levels as $key2=>$val2){
						$third_levels = $pdb->GetArray("SELECT id,name,parent_id,top_parentid FROM {$tb_prefix}industries t WHERE available=1 AND level=3 AND parent_id=".$val2['id']);
						$datas[$val['id']]['sub'][$val2['id']] = $val2['name'];
						$total_datas[2][$val2['id']] = $val2['name'];
						foreach($third_levels as $key3=>$val3){
							$datas[$val2['id']]['sub'][$val3['id']] = $total_datas[3][$val3['id']] = $val3['name'];
						}
					}
				}
				$top_levels = $this->convert2utf8($top_levels);
				$datas = $this->convert2utf8($datas);
				$op .= "'0':".json_encode($top_levels);
				$tmp_op = array();
				foreach ($top_levels as $js_key=>$js_val){
					if(isset($datas[$js_key])){
						foreach ($datas[$js_key] as $js_key1=>$js_val1) {
							$tmp_op[] = "'0,{$js_key}':".json_encode($datas[$js_key]['sub']);
							foreach ($datas[$js_key]['sub'] as $js_key2=>$js_val2) {
								if(!empty($datas[$js_key2]['sub'])) $tmp_op[] = "'0,{$js_key},{$js_key2}':".json_encode($datas[$js_key2]['sub']);
							}
						}
					}
				}
					if (!empty($tmp_op)) {
					$op .=",\n";
					$tmp_op = implode(",\n", $tmp_op);
					$op .= $tmp_op."\n}";
				}else{
					$op .= "\n}";
				}
				$fp = file_put_contents(CACHE_PATH. "industry.js", $op);
				unset($op);
				ksort($total_datas);
				$curdata = "\$_PB_CACHE['$cachename'] = ".$this->evalArray($total_datas).";\n\n";
			break;
			case 'newstype':
				$sql = "SELECT id,name FROM {$tb_prefix}newstypes nt ORDER BY nt.id DESC";
				$newstype_result = $pdb->GetArray($sql);
				if (!empty($newstype_result)) {
					foreach ($newstype_result as $ntkey=>$ntval) {
						$data[$ntval['id']] = $ntval['name'];
					}
				}
				$curdata = "\$_PB_CACHE['$cachename'] = ".$this->evalArray($data).";\n\n";
			break;
			case 'expotype':
				$sql = "SELECT id,name FROM {$tb_prefix}expotypes et ORDER BY et.id DESC";
				$fairtype_result = $pdb->GetArray($sql);
				if (!empty($fairtype_result)) {
					foreach ($fairtype_result as $etkey=>$etval) {
						$data[$etval['id']] = $etval['name'];
					}
				}
				$curdata = "\$_PB_CACHE['$cachename'] = ".$this->evalArray($data).";\n\n";
			break;
			case 'companytype':
				$sql = "SELECT id,name FROM {$tb_prefix}companytypes ct ORDER BY ct.id ASC";
				$companytype_result = $pdb->GetArray($sql);
				if (!empty($companytype_result)) {
					foreach ($companytype_result as $ctkey=>$ctval) {
						$data[$ctval['id']] = $ctval['name'];
					}
				}
				$curdata = "\$_PB_CACHE['$cachename'] = ".$this->evalArray($data).";\n\n";
			break;
			case 'membertype':
				$sql = "SELECT id,name FROM {$tb_prefix}membertypes ORDER BY id ASC";
				$membertyptype_result = $pdb->GetArray($sql);
				if (!empty($membertyptype_result)) {
					foreach ($membertyptype_result as $mtkey=>$mtval) {
						$data[$mtval['id']] = $mtval['name'];
					}
				}
				$curdata = "\$_PB_CACHE['$cachename'] = ".$this->evalArray($data).";\n\n";
			break;
			case 'userpage':
				$sql = "SELECT id,name,title,url,digest FROM {$tb_prefix}userpages ORDER BY display_order ASC,id ASC";
				$result = $pdb->GetArray($sql);
				if (!empty($result)) {
					$i=0;
					foreach ($result as $key=>$val) {
						$data[$i]['id'] = $val['id'];
						$data[$i]['title'] = $val['title'];
						$data[$i]['name'] = $val['name'];
						$data[$i]['digest'] = $val['digest'];
						if (!empty($val['url'])) {
							$data[$i]['url'] = $val['url'];
						}else{
							if(!empty($val['name'])){
								$data[$i]['url'] = "page.php?name=".$val['name'];
							}else{
								$data[$i]['url'] = "page.php?id=".$val['id'];
							}
						}
						$i++;
					}
				}
				$curdata = "\$_PB_CACHE['$cachename'] = ".$this->evalArray($data).";\n\n";
			break;			
			case 'membergroup':				
				$sql = "SELECT * FROM {$tb_prefix}membergroups mg ORDER BY mg.id DESC";
				$membergroup_result = $pdb->GetArray($sql);
				if (!empty($membergroup_result)) {
					foreach ($membergroup_result as $key=>$val) {
						$data[$val['id']]['name'] = $val['name'];
						$data[$val['id']]['max_offer'] = $val['max_offer'];
						$data[$val['id']]['type_id'] = $val['membertype_id'];
						$data[$val['id']]['max_product'] = $val['max_product'];
						$data[$val['id']]['max_job'] = $val['max_job'];
						$data[$val['id']]['max_companynews'] = $val['max_companynews'];
						$data[$val['id']]['max_market'] = $val['max_companynews'];
						$data[$val['id']]['max_album'] = $val['max_companynews'];
						$data[$val['id']]['max_producttype'] = $val['max_producttype'];
						$data[$val['id']]['max_attach_size'] = $val['max_attach_size'];
						$data[$val['id']]['max_size_perday'] = $val['max_size_perday'];
						$data[$val['id']]['max_favorite'] = $val['max_favorite'];
						$data[$val['id']]['type'] = $val['type'];
						$data[$val['id']]['avatar'] = $val['picture'];
						$data[$val['id']]['allow_space'] = $val['allow_space'];
						$tmp_allow = sprintf("%02b", $val['allow_offer']);
						$data[$val['id']]['offer_allow'] = intval($tmp_allow[0]);
						$data[$val['id']]['offer_check'] = intval($tmp_allow[1]);
						$tmp_allow = sprintf("%02b", $val['allow_market']);
						$data[$val['id']]['market_allow'] = intval($tmp_allow[0]);
						$data[$val['id']]['market_check'] = intval($tmp_allow[1]);
						$tmp_allow = sprintf("%02b", $val['allow_company']);
						$data[$val['id']]['company_allow'] = intval($tmp_allow[0]);
						$data[$val['id']]['company_check'] = intval($tmp_allow[1]);
						$tmp_allow = sprintf("%02b", $val['allow_product']);
						$data[$val['id']]['product_allow'] = intval($tmp_allow[0]);
						$data[$val['id']]['product_check'] = intval($tmp_allow[1]);
						$tmp_allow = sprintf("%02b", $val['allow_job']);
						$data[$val['id']]['job_allow'] = intval($tmp_allow[0]);
						$data[$val['id']]['job_check'] = intval($tmp_allow[1]);
						$tmp_allow = sprintf("%02b", $val['allow_companynews']);
						$data[$val['id']]['companynews_allow'] = intval($tmp_allow[0]);
						$data[$val['id']]['companynews_check'] = intval($tmp_allow[1]);
						$tmp_allow = sprintf("%02b", $val['allow_album']);
						$data[$val['id']]['album_allow'] = intval($tmp_allow[0]);
						$data[$val['id']]['album_check'] = intval($tmp_allow[1]);
						$data[$val['id']]['auth_level'] = intval($val['exempt']);
					}
				}
				$curdata = "\$_PB_CACHE['$cachename'] = ".$this->evalArray($data).";\n\n";
			break;
			default:
			break;
		}
		return $curdata;
	}
	
	function updateCache()
	{
		
	}
	
	function convert2utf8($str, $force = false)
	{
		global $charset, $chinese;
		if ($charset!="utf-8") {
			if(is_array($str)){
				return array_map(array('Caches','convert2utf8'), $str);
			}else{
				if (function_exists("mb_convert_encoding")) {
					return mb_convert_encoding($str, "utf-8", $charset);
				}elseif (function_exists("iconv")){
					return iconv($charset, "utf-8", $str);
				}else{
					$str = $chinese->Convert($str);
					return $str;
				}
			}
		}else{
			return $str;
		}
	}
}
?>