<?php
if(!defined('IN_UALINK')) exit('Access Denied');
require("member/menu.php");
uses("job");
$job = new Jobs();
$company_id = (empty($_GET['id']))?$companyinfo['ID']:intval($_GET['id']);
$res = $job->findAll(null, "Job.company_id=".$company_id, "id DESC", 0, 10);
setvar("CompanyJobs",$res);
setvar("Worktype",$job->worktype);
setvar("Salary",$job->salary);
template($tplpath."hr");
?>