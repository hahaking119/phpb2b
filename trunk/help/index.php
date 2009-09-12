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
 * @created Mon Jun 22 16:05:31 CST 2009
 * @link http://sourceforge.net/projects/php-b2b/
 * @version $Id: index.php 438 2009-07-07 14:28:27Z stevenchow811 $
 */
$inc_path = "../";
require("../global.php");
uses("helptype","help");
$helptype = new Helptypes();
$help = new Helps();
$conditions = null;
$tpl_file = "index";
$res = null;
if(isset($_GET['sid'])) {
	$type_id = intval($_GET['sid']);
	$conditions = "Help.helptype_id=".$type_id;
	$tpl_file = "content";
	$res = $help->findAll("id AS HelpId,title AS HelpTitle,description AS HelpContent",$conditions,"id DESC",0,25);
	setvar("HelpTopics",$res);
	$sname = $helptype->read("title AS HelptypeTitle",$type_id);
	setvar("HelptypeTitle",$sname['HelptypeTitle']);
	unset($res,$sname);
}
$parent_list = $helptype->findAll("id AS HelptypeId,title AS HelptypeTitle","Helptype.parent_id=0","id DESC",0,25);
for ($i=0; $i<count($parent_list); $i++) {
	$parent_list[$i]['sub_helps'] = $help->findAll("id AS HelpId,title AS HelpTitle","Help.helptype_id=".$parent_list[$i]['HelptypeId'],"id DESC",0,25);
}
setvar("HelpParents",$parent_list);
template($theme_name."/help_".$tpl_file);
?>