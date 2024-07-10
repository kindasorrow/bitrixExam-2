<?php

if($arParams["SPECIAL_DATE"] == "Y") {
    $arResult["FIRST_NEWS_DATE"] = $arResult["ITEMS"][0]["ACTIVE_FROM"];
    $this->__component->setResultCacheKeys(["FIRST_NEWS_DATE"]);
}