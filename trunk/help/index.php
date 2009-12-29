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
 * @version $Id: index.php 443 2009-12-26 13:49:49Z cht117 $
 */
define('CURSCRIPT', 'index');
require("../libraries/common.inc.php");
uses("helptype","help");
$helptype = new Helptypes();
$help = new Helps();
$conditions = array();
$tpl_file = "index";
$res = null;
if(isset($_GET['typeid'])) {
	$type_id = intval($_GET['typeid']);
	$conditions[] = "Help.helptype_id=".$type_id;
	$tpl_file = "content";
	$res = $help->findAll("id AS HelpId,title AS HelpTitle,description AS HelpContent",null, $conditions,"id DESC");
	setvar("Items",$res);
	$sname = $helptype->read("title AS HelptypeTitle",$type_id);
	setvar("HelptypeTitle",$sname['HelptypeTitle']);
	unset($res,$sname);
}
$parent_list = $helptype->findAll("id AS HelptypeId,title AS HelptypeTitle",null, "Helptype.parent_id=0","id DESC");
for ($i=0; $i<count($parent_list); $i++) {
	$parent_list[$i]['sub_helps'] = $help->findAll("id AS HelpId,title AS HelpTitle",null, "Help.helptype_id=".$parent_list[$i]['HelptypeId'],"id DESC",0,25);
}
setvar("HelpParents",$parent_list);
render("help.".$tpl_file);
?>