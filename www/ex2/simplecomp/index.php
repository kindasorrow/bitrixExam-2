<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Простой компонент");
?><?$APPLICATION->IncludeComponent(
	"exam2:simplecomp.exam2", 
	".default", 
	array(
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CATALOG_IBLOCK_ID" => "2",
		"FOREIGN_CODE_CATALOG" => "UF_NEWS_LINK",
		"NEWS_IBLOCK_ID" => "1",
		"COMPONENT_TEMPLATE" => ".default",
		"TEMPLATE_DETAIL_URL" => "/catalog_exam/#SECTION_ID#/#ELEMENT_ID#/",
		"ELEMENT_PER_PAGE" => "2"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>