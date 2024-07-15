<?
global $APPLICATION;
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;
global $USER;

if(!Loader::includeModule("iblock"))
{
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

if(empty($arParams['CACHE_TIME'])) {
    $arParams['CACHE_TIME'] = 36000000;
}

if(empty($arParams['PRODUCTS_IBLOCK_ID'])) {
    $arParams['PRODUCTS_IBLOCK_ID'] = 0;
}

if(empty($arParams['PROPERTY_CODE'])) {
    $arParams['PROPERTY_CODE'] = 'BRAND';
}

if(empty($arParams['CLASS_IBLOCK_ID'])) {
    $arParams['CLASS_IBLOCK_ID'] = 0;
}

if(empty($arParams['LINK_TO_DETAIL'])) {
    $arParams['LINK_TO_DETAIL'] = '';
}

if($this->StartResultCache(false, array($USER->GetGroups()))) {
    if (intval($arParams["PRODUCTS_IBLOCK_ID"]) > 0) {

        // BRANDS

        $brands = $brandIDs = [];

        $arSelectBrand = array(
            "ID",
            "IBLOCK_ID",
            "NAME",
        );
        $arFilterBrand = array(
            "IBLOCK_ID" => $arParams["CLASS_IBLOCK_ID"],
            "CHECK_PERMISSIONS" => $arParams["CACHE_GROUPS"],
            "ACTIVE" => "Y"
        );


        $rsBrands = CIBlockElement::GetList([], $arFilterBrand, false, false, $arSelectBrand);
        while ($arBrand = $rsBrands->GetNext()) {
            $brands[$arBrand["ID"]] = $arBrand;
            $brandIDs[] = $arBrand["ID"];
        }

        // PRODUCTS

        $products = array();
        $productIDs = array();

        $arSelectElems = array(
            "ID",
            "IBLOCK_ID",
            "NAME",
            "DETAIL_PAGE_URL",
            "PROPERTY_" . $arParams["PROPERTY_CODE"],
            "PROPERTY_PRICE",
            "PROPERTY_MATERIAL",
            "PROPERTY_ARTNUMBER",
        );
        $arFilterElems = array(
            "IBLOCK_ID" => $arParams["PRODUCTS_IBLOCK_ID"],
            "CHECK_PERMISSIONS" => $arParams["CACHE_GROUPS"],
            "PROPERTY_" . $arParams["PROPERTY_CODE"] => $brandIDs,
            "ACTIVE" => "Y"
        );


        $rsElements = CIBlockElement::GetList([], $arFilterElems, false, false, $arSelectElems);
        while ($arElement = $rsElements->GetNext()) {
            $brands[$arElement["PROPERTY_" . $arParams["PROPERTY_CODE"] . "_VALUE"]]["PRODUCTS"][$arElement["ID"]] = $arElement;
            $productIDs[] = $arElement["ID"];
        }

        $this->arResult["BRANDS"] = $brands;

        $this->arResult["COUNT"] = count($brandIDs);
        $APPLICATION->SetPageProperty('title', 'Разделов: ' . count($brandIDs));
        $this->setResultCacheKeys(['COUNT']);

    }
}
else {
    $this->AbortResultCache();
}

$this->includeComponentTemplate();