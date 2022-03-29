<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Тестовое задание");
?>

<?$APPLICATION->IncludeComponent(
	"simplecomp.exam", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"PRODUCTS_IBLOCK_ID" => "2",
		"NEWS_IBLOCK_ID" => "1",
		"CODE_UF_NEWS" => "UF_NEWS_LINK"
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>