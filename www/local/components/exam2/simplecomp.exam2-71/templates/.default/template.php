<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<p><b><?= GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE") ?></b></p>
<pre>
<?
print_r($arResult);
?>
</pre>

<ul>
    <? foreach ($arResult['BRANDS'] as $arItem): ?>
        <li>
            <b><?= $arItem['NAME'] ?></b>
            <ul>
            <?foreach ($arItem['PRODUCTS'] as $arProduct): ?>
            <li>
                <?=$arProduct["NAME"]?> - <?=$arProduct["PROPERTY_PRICE_VALUE"]?> - <?=$arProduct["PROPERTY_MATERIAL_VALUE"]?> - <?=$arProduct["PROPERTY_ARTNUMBER_VALUE"]?> -
                <a href="<?= $arProduct["DETAIL_PAGE_URL"] ?>"><?= GetMessage("SIMPLECOMP_EXAM2_DETAIL") ?></a>
            </li>
            <?endforeach;?>
            </ul>
        </li>
    <? endforeach; ?>
</ul>