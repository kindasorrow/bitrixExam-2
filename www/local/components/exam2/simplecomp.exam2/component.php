<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

if (!isset($arParams["CACHE_TIME"])) {
    $arParams["CACHE_TIME"] = 360000000;
}

if (!isset($arParams["CATALOG_IBLOCK_ID"])) {
    $arParams["CATALOG_IBLOCK_ID"] = 0;
}

if (!isset($arParams["NEWS_IBLOCK_ID"])) {
    $arParams["NEWS_IBLOCK_ID"] = 0;
}

if ($this->startResultCache()) { // Если нету кеша

    // Получение новостей

    $arNews = array();
    $arNewsID = array();
    $arSection = array();
    $arSectionID = array();

    $obNews = CIBlockElement::GetList(
        array(),
        array("IBLOCK_ID" => $arParams["NEWS_IBLOCK_ID"], "ACTIVE" => "Y"),
        false,
        false,
        ["ID", "NAME", "ACTIVE_FROM"]
    );

    while ($news = $obNews->Fetch()) {
        $arNewsID[] = $news["ID"];
        $arNews[$news["ID"]] = $news;
    }


    //Получение секций продукции

    $obSection = CIBlockSection::GetList(
        array(),
        array("IBLOCK_ID" => $arParams["CATALOG_IBLOCK_ID"], "ACTIVE" => "Y", $arParams["FOREIGN_CODE_CATALOG"] => $arNewsID),
        true,
        ["ID", "IBLOCK_ID", "NAME", $arParams["FOREIGN_CODE_CATALOG"]]);

    while ($section = $obSection->Fetch()) {
        $arSectionID[] = $section["ID"];
        $arSection[$section["ID"]] = $section;
    }

    // Получение элементов продукции

    $obElement = CIBlockElement::GetList(
        array(),
        array("IBLOCK_ID" => $arParams["CATALOG_IBLOCK_ID"], "ACTIVE" => "Y", "SECTION_ID" => $arSectionID),
        false,
        false,
        ["ID", "IBLOCK_SECTION_ID", "IBLOCK_ID", "NAME", "PROPERTY_MATERIAL", "PROPERTY_ARTNUMBER", "PROPERTY_PRICE"]);

    while ($element = $obElement->Fetch()) {
        foreach ($arSection[$element["IBLOCK_SECTION_ID"]][$arParams["FOREIGN_CODE_CATALOG"]] as $newsID) {
            $arNews[$newsID]["ELEMENTS"][] = $element;
        }
    }

    $productCount = 0;
    foreach ($arSection as $section) {

        $productCount += $section["ELEMENT_CNT"];
        foreach ($section[$arParams["FOREIGN_CODE_CATALOG"]] as $newsID) {
            $arNews[$newsID]["SECTIONS"][] = $section["NAME"];
        }
    }

    $this->arResult = ["NEWS" => $arNews, "PRODUCT_COUNT" => $productCount];
    $this->setResultCacheKeys(array("PRODUCT_COUNT"));
    $this->includeComponentTemplate();

} else { // Кэш есть --> не кэшируем
    $this->abortResultCache();
}

$APPLICATION->SetTitle(GetMessage('title',["#count#" => $this->arResult["PRODUCT_COUNT"]]));
?>