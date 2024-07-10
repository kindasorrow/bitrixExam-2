<?php

if(!empty($arParams["REL_CANONICAL"])) {
    $arSelect = Array("ID", "IBLOCK_ID", "NAME", "PROPERTY_NEW");
    $arFilter = Array("IBLOCK_ID"=>IntVal($arParams["REL_CANONICAL"]), "PROPERTY_NEW"=>$arResult["ID"], "ACTIVE"=>"Y");

    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);

    if($ob = $res->GetNextElement()){
        $arFields = $ob->GetFields();
        $arResult["REL_CANONICAL"] = $arFields["NAME"];
        $this->__component->setResultCacheKeys(["REL_CANONICAL"]);
    }
}