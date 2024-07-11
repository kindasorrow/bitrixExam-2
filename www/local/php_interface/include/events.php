<?php
IncludeModuleLangFile(__FILE__);

AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", array("Ex2", "OnBeforeProductUpdateHandler"));
AddEventHandler("main", "OnEpilog", array("Ex2", "Error404Handler"));
AddEventHandler("main", "OnBeforeEventAdd", array("Ex2", "OnBeforeEventAddHandler"));

class Ex2
{
    public static function OnBeforeProductUpdateHandler(&$arFields): bool
    {
        global $APPLICATION;

        if ($arFields["IBLOCK_ID"] == IBLOCK_CATALOG) {
            if ($arFields["ACTIVE"] == "N") {

                $arSelect = array("ID", "NAME", "SHOW_COUNTER");
                $arFilter = array("IBLOCK_ID" => IBLOCK_CATALOG, "ID" => $arFields["ID"]);
                $res = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);

                $ob = $res->Fetch();
                echo $ob["SHOW_COUNTER"];

                if ($ob["SHOW_COUNTER"] > MAX_COUNT) {
                    $message = GetMessage("EX2_ERROR_DEACTIVATE_PRODUCT", array("#SHOW_COUNTER#" => $ob["SHOW_COUNTER"]));
                    $APPLICATION->throwException($message);
                    return false;
                }

            }
        }

        return true;
    }

    public static function Error404Handler()
    {
        if (defined('ERROR_404') && ERROR_404 == "Y") {
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

    public static function OnBeforeEventAddHandler(&$event, &$lid, &$arFields)
    {
        if ($event == "FEEDBACK_FORM") {
            global $USER;
            if ($USER->IsAuthorized()) {
                $message = GetMessage("EX2_MAIL_AUTHORISED_USER", [
                    '#ID#' => $USER->GetID(),
                    '#NAME#' => $USER->GetFullName(),
                    '#LOGIN#' => $USER->GetLogin(),
                    '#AUTHOR#' => $arFields['AUTHOR']
                ]);
            }
            else {
                $message = GetMessage("EX2_MAIL_UNAUTHORISED_USER", ['#AUTHOR#' => $arFields['AUTHOR']]);
            }
            $arFields['AUTHOR'] = $message;

            CEventLog::Add([
                'SEVERITY' => 'INFO',
                "AUDIT_TYPE_ID" => "MY_OWN_TYPE",
                "MODULE_ID" => "main",
                "ITEM_ID" => $event,
                'USER_ID' => $USER->IsAuthorized() ? $USER->GetID() : NULL,
                'DESCRIPTION' => GetMessage('EX2_CHANGED_MAIL_LOG', [
                    '#AUTHOR#' => $message
                ])
            ]);
        }

    }
}

