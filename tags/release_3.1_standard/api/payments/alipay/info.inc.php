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
$cfg['name'] = 'alipay';
$cfg['title'] = '支付宝';
$cfg['description'] = '阿里支付宝';
//配置信息
$cfg['params']['gateway'] = 'https://www.alipay.com/cooperate/gateway.do';
$cfg['params']['_input_charset'] = 'GBK';
$cfg['params']['sign_type'] = 'MD5';
?>