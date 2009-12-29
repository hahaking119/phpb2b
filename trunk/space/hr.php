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
 * @version $Id: hr.php 481 2009-12-28 01:05:06Z steven $
 */
if(!defined('IN_PHPB2B')) exit('Not A Valid Entry Point');
uses("job");
require(LIB_PATH. "typemodel.inc.php");
$job = new Jobs();
$conditions = "company_id=".$company->info['id'];
if (isset($_GET['id'])) {
	$id = intval(($_GET['id']));
	if ($id) {
		$info = $job->read("*", intval($_GET['id'], $conditions));
		if (empty($info)) {
			flash('data_not_exists');
		}
		$tpl_file = "hr_detail";
		setvar("item",$info);
		$space->render($tpl_file);
		exit;
	}
}
$res = $job->findAll("*", null, $conditions, "id DESC", 0, 10);
$sql = "UPDATE {$tb_prefix}jobs SET clicked=clicked+1 WHERE status=1 AND company_id=".$company->info['id'];
$pdb->Execute($sql);
setvar("Items",$res);
setvar("Worktype", get_cache_type("work_type"));
setvar("Salary", get_cache_type("salary"));
$space->render("hr");
?>