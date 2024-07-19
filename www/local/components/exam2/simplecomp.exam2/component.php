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

$isFilterSet = isset($_REQUEST["F"]);

global $USER;
global $CACHE_MANAGER;

if($USER->IsAuthorized()) {
    $arButtons = CIBlock::GetPanelButtons($arParams["CATALOG_IBLOCK_ID"]);
    echo "<pre>";
    //print_r($arButtons);
    echo "</pre>";
    $this->AddIncludeAreaIcon([
        'ID' => "linklb",
        'TITLE' => GetMessage('IBLOCK_ADMIN_LINK'),
        'URL' => $arButtons['submenu']['element_list']['ACTION_URL'],
        'IN_PARAMS_MENU' => true,
        'IN_MENU' => false,
    ]);
}

$arNavigation = CDBResult::GetNavParams($arParams["ELEMENT_PER_PAGE"]);

if ($this->startResultCache(false, [$isFilterSet, $arNavigation], '/servicesIblock')) { // Если нету кеша

    $CACHE_MANAGER->RegisterTag('iblock_id_3');
    // Получение новостей

    $arNews = array();
    $arNewsID = array();
    $arSection = array();
    $arSectionID = array();

    $obNews = CIBlockElement::GetList(
        array(),
        array("IBLOCK_ID" => $arParams["NEWS_IBLOCK_ID"], "ACTIVE" => "Y"),
        false,
        ["nPageSize" => $arParams["ELEMENT_PER_PAGE"], "bShowAll" => false],
        ["ID", "NAME", "ACTIVE_FROM"]
    );

    $arResult["NAV_STRING"] = $obNews->GetPageNavString("");

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

    $arFilterElements = [
        "IBLOCK_ID" => $arParams["CATALOG_IBLOCK_ID"],
        "ACTIVE" => "Y",
        "SECTION_ID" => $arSectionID
    ];
    if($isFilterSet) {
        $arFilterElements[] = [
            ["<=PROPERTY_PRICE" => 1700, "PROPERTY_MATERIAL" => "Дерево, ткань"],
            ["<PROPERTY_PRICE" => 1500, "PROPERTY_MATERIAL" => "Металл, пластик"],
            "LOGIC" => "OR"
        ];

        $this->abortResultCache();
    }

    $obElement = CIBlockElement::GetList(
        array('NAME'=> 'asc', 'SORT' => 'asc'),
        $arFilterElements,
        false,
        false,
        ["ID", "IBLOCK_SECTION_ID", "IBLOCK_ID", "NAME", "PROPERTY_MATERIAL", "PROPERTY_ARTNUMBER", "PROPERTY_PRICE"]);

    while ($element = $obElement->Fetch()) {



        // ЭРМИТАЖ

        $arButtons = CIBlock::GetPanelButtons(
            $arParams["CATALOG_IBLOCK_ID"],
            $element["ID"],
            0,
            array("SECTION_BUTTONS"=>false, "SESSID"=>false)
        );

        $element["EDIT_LINK"] = $arButtons["edit"]["edit_element"]["ACTION_URL"];
        $element["DELETE_LINK"] = $arButtons["edit"]["delete_element"]["ACTION_URL"];
        $this->arResult['ADD_LINK'] = $arButtons["edit"]["add_element"]["ACTION_URL"];


        $element["DETAIL_PAGE_URL"] = str_replace(
          array('#SECTION_ID#', '#ELEMENT_ID#'),
          array(
            $element["IBLOCK_SECTION_ID"],
            $element["ID"]
          ),
            $arParams["TEMPLATE_DETAIL_URL"]
        );

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

    $this->arResult['NEWS'] = $arNews;
    $this->arResult["PRODUCT_COUNT"] = $productCount;
    $this->arResult['IBLOCK_ID'] = $arParams["CATALOG_IBLOCK_ID"];

    $this->setResultCacheKeys(array("PRODUCT_COUNT"));
    $this->includeComponentTemplate();

} else { // Кэш есть --> не кэшируем
    $this->abortResultCache();
}

$APPLICATION->SetTitle(GetMessage('title',["#count#" => $this->arResult["PRODUCT_COUNT"]]));
?>