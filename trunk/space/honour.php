<?php
if(!defined('IN_PHPB2B')) exit('Not A Valid Entry Point');
uses("attachment");
$attach = new Attachments();
$result = $attach->findAll($attach->getFieldAliasNames(), "company_id=".$companyinfo['ID'], "id desc", 0, 12);
setvar("CompanyAttachment", $result);
template("../skins/".$tplpath."honour");
?>