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
 * @version $Id: overloadable_php5.php 420 2009-12-26 13:37:06Z cht117 $
 */
class Overloadable extends PbObject {
	function overload() { }

	function __call($method, $params) {
		if (!method_exists($this, 'call__')) {
			trigger_error(sprintf('Magic method handler call__ not defined in %s', get_class($this)), E_USER_ERROR);
		}
		return $this->call__($method, $params);
	}
}

class Overloadable2 extends PbObject {
	function overload() { }

	function __call($method, $params) {
		if (!method_exists($this, 'call__')) {
			trigger_error(sprintf('Magic method handler call__ not defined in %s', get_class($this)), E_USER_ERROR);
		}
		return $this->call__($method, $params);
	}

	function __get($name) {
		return $this->get__($name);
	}

	function __set($name, $value) {
		return $this->set__($name, $value);
	}
}
?>