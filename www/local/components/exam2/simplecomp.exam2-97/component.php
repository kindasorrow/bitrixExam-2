<?
global $APPLICATION;
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader,
    Bitrix\Iblock;

global $USER;

if (!Loader::includeModule("iblock")) {
    ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
    return;
}

if (!$USER->IsAuthorized()) {
    return;
}

if (empty($arParams['CACHE_TIME'])) {
    $arParams['CACHE_TIME'] = 36000000;
}

if (empty($arParams['NEWS_IBLOCK_ID'])) {
    $arParams['NEWS_IBLOCK_ID'] = 0;
}

if (empty($arParams['AUTHOR_IBLOCK_ID'])) {
    $arParams['AUTHOR_IBLOCK_ID'] = 0;
}

if (empty($arParams['PROPERTY_CODE'])) {
    $arParams['PROPERTY_CODE'] = 0;
} else {
    $arParams['PROPERTY_CODE'] = trim($arParams['PROPERTY_CODE']);
}

$userID = $USER->GetID();
$userType = CUser::GetList('id', 'ASC', ['ID' => $userID], ['SELECT' => [$arParams["PROPERTY_CODE"]]])->Fetch()[$arParams["PROPERTY_CODE"]];
$count = 0;
$arResult['COUNT'] = $count;

if ($this->StartResultCache(false, [$userID, $userType])) {

    if ($arParams["AUTHOR_IBLOCK_ID"] !== 0 && (int)$arParams["NEWS_IBLOCK_ID"] > 0 && $arParams["PROPERTY_CODE"] !== 0) {


        // USERS


        $usersIDs = [];
        $arOrderUser = array("id");
        $sortOrder = "asc";
        $arFilterUser = array(
            "ACTIVE" => "Y",
            $arParams["PROPERTY_CODE"] => $userType,
            "!ID" => $userID,
        );

        $users = array();
        $rsUsers = CUser::GetList($arOrderUser, $sortOrder, $arFilterUser); // выбираем пользователей
        while ($arUser = $rsUsers->GetNext()) {
            $users[$arUser['ID']] = ['ID' => $arUser['ID'], 'LOGIN' => $arUser['LOGIN']];
            $usersIDs[] = $arUser['ID'];
        }

        //NEWS

        $arNewsAuthor = array();

        $arSelectElems = array(
            "ID",
            "IBLOCK_ID",
            "NAME",
            "ACTIVE_FROM",
            "PROPERTY_AUTHOR",
        );
        $arFilterElems = array(
            "IBLOCK_ID" => $arParams["NEWS_IBLOCK_ID"],
            "ACTIVE" => "Y",
            "PROPERTY_AUTHOR" => $usersIDs
        );
        $arSortElems = array(
            "NAME" => "ASC"
        );

        $arResult["ELEMENTS"] = array();
        $rsElements = CIBlockElement::GetList($arSortElems, $arFilterElems, false, false, $arSelectElems);

        while ($arElement = $rsElements->GetNext()) {
            $arNewsAuthor[$arElement["PROPERTY_AUTHOR_VALUE"]][] = $arElement;
            $count++;
        }

        $arResult['COUNT'] = $count;

        foreach ($usersIDs as $userID) {
            $arResult["USER_NEWS"][$userID]['ID'] = $userID;
            $arResult["USER_NEWS"][$userID]['LOGIN'] = $users[$userID]['LOGIN'];
            $arResult["USER_NEWS"][$userID]['NEWS'] = $arNewsAuthor[$userID];

        }

    }
    $this->SetResultCacheKeys(['COUNT']);
    $this->includeComponentTemplate();
} else {
    $this->AbortResultCache();
}

$APPLICATION->SetPageProperty('title', GetMessage("TITLE", ["#count#" => $count]));
?>