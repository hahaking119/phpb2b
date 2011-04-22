<?php
$inc_path = "../";
require($inc_path."global.php");
uses("company");
$company = new Companies();
$instanceid = intval($_GET['cid']);
$company_id = (empty($instanceid)) ? 1 : $instanceid;
$res = $company->read("name,CONCAT(telcode,'-',telzone,'-',tel) AS tel,CONCAT(faxcode,'-',faxzone,'-',fax) AS fax,address,zipcode,email,site_url AS url",$company_id, null, "status=1");
$xmlstr = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$xmlstr.= "<cards>\n";
$xmlstr.= "<card ";
while(list($key,$val) = each($res)){
	if(!function_exists("iconv")){
		$xmlstr.=$key."=\"".$val."\" ";
	}else{
		$xmlstr.=$key."=\"".iconv("gb2312","utf-8",$val)."\" ";
	}
}
$xmlstr.=" />\n";
$xmlstr.="</cards>";
echo $xmlstr;
?>