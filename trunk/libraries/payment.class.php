<?php
class Payments extends PbObject
{
    var $_gateway   = '';		//外部处理网关
    var $_code      = '';		//支付方式唯一标识

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