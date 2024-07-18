<?php


if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if(isset($arResult['MIN_PRICE'], $arResult['MAX_PRICE'])) {
    $priceRange = '<div style="color:red; margin: 34px 15px 35px 15px"> ---' .  $arResult['MIN_PRICE'] . ' - ' . $arResult['MAX_PRICE'] . '---</div>';
    echo $priceRange;
    $APPLICATION->AddViewContent('priceRange', $priceRange);
}

