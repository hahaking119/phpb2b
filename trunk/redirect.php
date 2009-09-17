<?php
/**
 * Note : The Software shall be used for Good, not Evil.
 * PHPB2B - As an open source b2b program.
 *
 * Permission is hereby granted to use this version of the library under the
 * following license:
 * --
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
 * @created Mon Jun 22 16:06:23 CST 2009
 * @link http://sourceforge.net/projects/php-b2b/
 * @version $Id$
 */
$inc_path = null;
require("global.php");
if (!empty($_GET['message'])) {
	$action_alert = urldecode($_GET['message']);
}else{
	$action_alert = ($_GET['r'] == 1)?lgg('action_success'):lgg('action_false');
}
if(isset($_GET['c'])){
	if($_GET['c']=="n"){
		setvar("closeBtn", false);
	}else{
		setvar("closeBtn", true);
	}
}
if($_GET['b']=="n"){
	setvar("backBtn", false);
}else{
	setvar("backBtn", true);
}
if (empty($action_alert)) {
	$action_alert = L('undefined_operation');
}
$alert_title=($_GET['result']=="success")?lgg('congratulate'):lgg('sth_wrong');
setvar("AlertTitle", strip_tags($alert_title));
setvar("ActionAlert",$action_alert);
template($theme_name."/message");
?>