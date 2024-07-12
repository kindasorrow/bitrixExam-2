<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
	return;


$arComponentParameters = array(
	"PARAMETERS" => array(

		"CACHE_TIME"  =>  Array("DEFAULT"=>36000000),
		"CATALOG_IBLOCK_ID" => [
			"NAME" => GetMessage("IBLOCK_CATALOG_IBLOCK_ID"),
			"PARENT" => "BASE",
			"TYPE" => "STRING",
		],
		"NEWS_IBLOCK_ID" => [
			"NAME" => GetMessage("NEWS_IBLOCK_ID"),
			"PARENT" => "BASE",
			"TYPE" => "STRING",
		],
		"FOREIGN_CODE_CATALOG" => [
			"NAME" => GetMessage("FOREIGN_CODE_CATALOG"),
			"PARENT" => "BASE",
			"TYPE" => "STRING",
		],
	),
);
?>
