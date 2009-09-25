<?php
class Products extends PbModel {


 	var $name = "Product";
 	var $common_cols = "sort_id AS ProductSortId,Product.sn AS SerialNumber,Product.id AS ID,industry_id AS IndustryID,Product.name AS Name,Product.picture AS ProductPicture,content AS Description,Product.created AS CreateDate,Product.status AS ProductStatus,Product.state AS ProductState,html_file_id AS HtmlFileId";
 	var $industry_cols = "Product.id,Product.member_id as MemberId,Product.id AS ProductId,Product.name AS Name,Product.name AS ProductName,Product.content AS Content,Product.industry_id AS IndustryID,Product.picture,Product.created,Product.keywords AS ProductKeywords";

 	function Products()
 	{

 	}

	function checkProducts($id = null, $status = null)
	{
		if(is_array($id)){
			$checkId = "id in (".implode(",",$id).")";
		}else {
			$checkId = "id=".$id;
		}
		$sql = "UPDATE ".$this->getTable()." SET status=".$status." WHERE ".$checkId;
		$return = $GLOBALS['g_db']->Execute($sql);
		if($return){
			return true;
		}else {
			return false;
		}
	}
}
?>