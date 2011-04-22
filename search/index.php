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
 * @version $Id$
 */
define('CURSCRIPT', 'index');
require("../libraries/common.inc.php");
$conditions = null;
$tpl_file = "search";
uses("industry", "area");
$industry = new Industries();
$area = new Areas();
$parent_industry = $pdb->GetArray("SELECT id,name FROM ".$industry->getTable()." WHERE parent_id=0;");
setvar("ParentIndustry", $parent_industry);
$parent_area = $pdb->GetArray("SELECT id,code_id,name FROM ".$area->getTable()." WHERE INSTR(code_id,'0000');");
setvar("ParentArea", $parent_area);
render($tpl_file);
?>