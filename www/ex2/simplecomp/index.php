<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Простой компонент");
?><?$APPLICATION->IncludeComponent(
	"exam2:simplecomp.exam2",
	"",
	Array(
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"CATALOG_IBLOCK_ID" => "2",
		"FOREIGN_CODE_CATALOG" => "UF_NEWS_LINK",
		"NEWS_IBLOCK_ID" => "1"
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>