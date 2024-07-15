<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(
		"NEWS_IBLOCK_ID" => array(
			"NAME" => GetMessage("NEWS_IBLOCK_ID"),
            "PARENT" => "BASE",
			"TYPE" => "STRING",
		),
        "AUTHOR_IBLOCK_ID" => array(
            "NAME" => GetMessage("AUTHOR_IBLOCK_ID"),
            "PARENT" => "BASE",
            "TYPE" => "STRING",
        ),
        "PROPERTY_CODE" => array(
            "NAME" => GetMessage("PROPERTY_CODE"),
            "PARENT" => "BASE",
            "TYPE" => "STRING",
        ),

        "CACHE_TIME"  =>  Array("DEFAULT"=>36000000),
        "CACHE_GROUPS" => [
            "PARENT" => "CACHE_SETTINGS",
            "NAME" => GetMessage("CP_BNL_CACHE_GROUPS"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
        ],
	),
);