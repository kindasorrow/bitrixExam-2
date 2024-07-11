<?php
IncludeModuleLangFile(__FILE__);

AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", array("Ex2", "OnBeforeProductUpdateHandler"));

class Ex2
{
    public static function OnBeforeProductUpdateHandler(&$arFields): bool
    {
        global $APPLICATION;

        if ($arFields["IBLOCK_ID"] == IBLOCK_CATALOG) {
            if ($arFields["ACTIVE"] == "N") {

                $arSelect = Array("ID", "NAME", "SHOW_COUNTER");
                $arFilter = Array("IBLOCK_ID"=>IBLOCK_CATALOG, "ID" => $arFields["ID"]);
                $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);

                $ob = $res->Fetch();
                echo $ob["SHOW_COUNTER"];

                if($ob["SHOW_COUNTER"] > MAX_COUNT) {
                    $message = GetMessage("EX2_ERROR_DEACTIVATE_PRODUCT", array("#SHOW_COUNTER#" => $ob["SHOW_COUNTER"]));
                    $APPLICATION->throwException($message);
                    return false;
                }

            }
        }

        return true;
    }
}

