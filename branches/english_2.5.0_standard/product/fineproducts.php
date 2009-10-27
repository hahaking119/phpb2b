<?php
$conditions = "Product.state=1 and Product.status=1 and Product.member_id=".intval($member_id);
$fineproducts = $product->findAll($product->common_cols,$conditions,"Product.id DESC",0,8);
setvar("FineProducts",$fineproducts);
?>