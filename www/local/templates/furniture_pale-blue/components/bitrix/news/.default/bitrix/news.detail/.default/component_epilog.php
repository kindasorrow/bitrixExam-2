<?php
if(isset($arResult["REL_CANONICAL"])) {
     $APPLICATION->SetPageProperty("canonical",
     $arResult["REL_CANONICAL"]);
}