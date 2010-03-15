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
//基本信息
$cfg['name'] = 'tenpay';
$cfg['title'] = '腾讯财付通';
$cfg['description'] = '腾讯财付通';
//配置信息
$cfg['params']['gateway'] = 'https://www.tenpay.com/cgi-bin/med/show_opentrans.cgi';
$cfg['params']['security_code'] = '';
?>