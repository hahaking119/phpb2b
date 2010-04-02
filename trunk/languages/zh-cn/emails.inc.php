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
 * @version $Id: emails.inc.php 942 2010-02-09 00:49:26Z steven $
 */
$arrTemplate['_get_passwd_subject'] = "取回密码说明";
$arrTemplate['_after_update_please'] = "更新密码后,请您及时到";
$arrTemplate['_office_room_update_passwd'] = "商务室更新您的密码,以防丢失.";
$arrTemplate['_dear_user'] = "尊敬的客户";
$arrTemplate['_a_test_email'] = "这是一封来自".$_PB_CACHE['setting']['site_name']."的测试邮件。";
$arrTemplate['_a_test_email_delete'] = "这是一封来自<a href=\"".URL."\" target='_blank'>".$_PB_CACHE['setting']['site_name']."</a>的测试邮件，你可以删除它。";
$arrTemplate['_pls_active_your_account'] = "请激活您的帐号";
$arrTemplate['_pls_pending_account'] = "请点击 : <a href='".URL."pending.php?do=member&action=activate&hash=%hash%'>".URL."pending.php?hash=%hash%</a>激活您的帐号。";
?>