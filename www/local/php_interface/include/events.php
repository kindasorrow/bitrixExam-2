<?php
IncludeModuleLangFile(__FILE__);

AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", array("Ex2", "OnBeforeProductUpdateHandler"));
AddEventHandler("main", "OnEpilog", array("Ex2", "Error404Handler"));

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

    public static function Error404Handler() {
        if(defined('ERROR_404') && ERROR_404 == "Y") {
            global $APPLICATION;
            $APPLICATION->RestartBuffer();

            include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/header.php';
            include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/404.php';
            include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/footer.php';

            CEventLog::Add(

                array(

                    "SEVERITY" => "INFO",
                    "AUTH_TYPE_ID" => "ERROR_404",
                    "MODULE_ID" => "main",
                    "DESCRIPTION" => $APPLICATION->GetCurPage(),
                    )
            );
        }
    }
}

