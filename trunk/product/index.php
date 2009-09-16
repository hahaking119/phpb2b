<?php
$inc_path = "../";
$li = 4;
require($inc_path."global.php");
require(SOURCE_PATH .'xajax/xajaxAIO.inc.php');
uses("product","member","industry", "htmlcache");
$htmlcache = new Htmlcaches();
$industry = new Industries();
$product = new Products();
$xajax = new xajax();
$xajax->configure('javascript URI', URL."app/source/xajax/");
$smarty->register_function("format_amount","splitIndustryAmount");
$xajax->register(XAJAX_FUNCTION, new xajaxUserFunction('getIndustryList', '../ajax.php'));
$xajax->register(XAJAX_FUNCTION,  new xajaxUserFunction('rebuildHTML', '../ajax.php'));
$xajax->processRequest();
$_titles[] = lgg("product_center");
$_positions = null;
setvar('xajax_javascript', $xajax->getJavascript());
$latest_products = $product->findAll("Product.id AS ID,Product.picture AS ProductPicture,Product.name AS ProductName,html_file_id AS HtmlFileId","Product.status=1 and Product.state=1","Product.id DESC",0,8);
$recommend_products = $product->findAll("Product.id AS ID,Product.picture AS ProductPicture,Product.name AS ProductName,html_file_id AS HtmlFileId","Product.status=1 and Product.state=1 and Product.ifcommend=1","Product.id DESC",0,18);
setvar("LatestProducts",$latest_products);
setvar("RecommendProducts",$recommend_products);
setvar("ProductAmount", $g_db->GetOne("select sc from {$tb_prefix}stats where sb='product'"));
setvar("IndustryList", $industry->getIndustryPage($li,"product","industry1"));
if (isset($_GET['action']) && $_GET['action']=="html") {
	$smarty->MakeHtmlFile('../htmls/product/index.html',$smarty->fetch($theme_name."/product_index.html"), true, "product/index.php");
}
$product->setPageTitle($_titles, $_positions);
setvar("pageTitle", $product->title);
template($theme_name."/product_index");
?>