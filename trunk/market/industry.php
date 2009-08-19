<?php
$fields = "Industry.id AS IndustryId,name as IndustryName";
$res = $industry->findAll($fields," 1 AND ib=1",  "id desc", 0, 20);
setvar("ListIndustry",$res);
?>