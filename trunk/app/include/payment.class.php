<?php
class Payments extends UaObject
{
    /* 外部处理网关 */
    var $_gateway   = '';
    /* 支付方式唯一标识 */
    var $_code      = '';

    function __construct()
    {
        $this->Payments();
    }

    function Payments()
    {
		return true;
    }
}
?>