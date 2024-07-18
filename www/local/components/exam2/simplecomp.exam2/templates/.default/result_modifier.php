<?php

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arPrice = [];

//echo "<pre>";
foreach ($arResult['NEWS'] as $news) {
    foreach ($news['ELEMENTS'] as $element) {
        $arPrice[] = $element['PROPERTY_PRICE_VALUE'];
        //print_r($element['PROPERTY_PRICE_VALUE']);
        //echo PHP_EOL;
    }
}
//echo "</pre>";


$arResult['MIN_PRICE'] = min($arPrice);
$arResult['MAX_PRICE'] = max($arPrice);

$this->__component->SetResultCacheKeys(['MIN_PRICE', 'MAX_PRICE']);