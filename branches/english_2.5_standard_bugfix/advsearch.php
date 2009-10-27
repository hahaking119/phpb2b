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
 * @copyright 2009 Ualink <phpb2b@hotmail.com> (http://www.phpb2b.com/)
 * @license http://www.opensource.org/licenses/gpl-license.php GPL License
 * @created Mon Jun 22 16:06:28 CST 2009
 * @link http://sourceforge.net/projects/php-b2b/
 * @version $Id$
 */
$inc_path = "./";
require("global.php");
$conditions = null;
$tpl_file = "search";
uses("industry", "area");
$industry = new Industries();
$area = new Areas();
$parent_industry = $g_db->GetArray("select id,name from ".$industry->getTable()." where parentid=0;");
setvar("ParentIndustry", $parent_industry);
$parent_area = $g_db->GetArray("select id,code_id,name from ".$area->getTable()." where INSTR(code_id,'0000');");
setvar("ParentArea", $parent_area);
template($theme_name."/".$tpl_file);
?>