<?php
if(!defined('IN_UALINK')) exit('Access Denied');
uses("attachment");
$attach = new Attachments();
$result = $attach->findAll($attach->getFieldAliasNames(), "company_id=".$companyinfo['ID'], "id desc", 0, 12);
setvar("CompanyAttachment", $result);
template("../skins/".$tplpath."honour");
?>