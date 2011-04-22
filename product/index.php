<?php
//$li = 4;
$index_latest_industry_ids = 10;
$data = array();
define('CURSCRIPT', 'index');
require("../libraries/common.inc.php");
require(CACHE_PATH. "cache_industry.php");
uses("product","industry");
$industry = new Industries();
$product = new Products();
setvar("Industry", $_PB_CACHE['industry'][1]);
$ProductSorts = explode(",",L('product_sorts', 'tpl'));
$result = $pdb->GetArray($sql = "SELECT distinct industry_id1 AS iid FROM {$tb_prefix}products WHERE status=1 ORDER BY id DESC LIMIT 0,{$index_latest_industry_ids}");
if (!empty($result)) {
	foreach ($result as $key=>$val) {
		$data[$val['iid']]['id'] = $val['iid'];
		$data[$val['iid']]['name'] = $_PB_CACHE['industry'][1][$val['iid']];
		$tmp_result = $pdb->GetArray("SELECT id,name,picture,sort_id FROM {$tb_prefix}products WHERE status=1 AND industry_id1=".$val['iid']." ORDER BY id DESC LIMIT 0,5");
		if (!empty($tmp_result)) {
			foreach ($tmp_result as $key1=>$val1) {
				$data[$val['iid']]['sub'][$val1['id']]['id'] = $val1['id'];
				$data[$val['iid']]['sub'][$val1['id']]['name'] = $val1['name'];
				$data[$val['iid']]['sub'][$val1['id']]['sort'] = $ProductSorts[$val1['sort_id']];
				$data[$val['iid']]['sub'][$val1['id']]['image'] = pb_get_attachmenturl($val1['picture'], '', 'small');
			}
		}
	}
	setvar("IndustryProducts", $data);
}
render("product.index");
?>