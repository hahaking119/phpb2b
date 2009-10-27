<?php
if(!defined('IN_UALINK')) exit('Access Denied');
require("member/menu.php");
uses("attachment");
$attach = new Attachments();
$result = $attach->findAll($attach->getFieldAliasNames(), "company_id=".$companyinfo['ID'], "id desc", 0, 12);
setvar("CompanyAttachment", $result);
template($tplpath."honour");
?>