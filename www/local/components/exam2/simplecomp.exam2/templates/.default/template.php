<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<p><b><?= GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE") ?>:</b></p>
<p><?=GetMessage("SIMPLECOMP_EXAM2_COUNT", ["#count#" => $arResult['PRODUCT_COUNT']])?></p>

<?php

$url = $APPLICATION->GetCurPage() . "?F=Y";

?>

<a href="<?=$url?>"><?=$url?></a>
<ul>
    <?php foreach ($arResult["NEWS"] as $news): ?>
        <li><b><?= $news["NAME"] ?></b> - <?= $news["ACTIVE_FROM"] ?> (<?= implode(', ', $news['SECTIONS']); ?>)

            <? if (count($news['ELEMENTS']) > 0): ?>
                <ul>
                    <?php foreach ($news['ELEMENTS'] as $element): ?>
                        <li>
                            <span><?= $element['NAME'] ?> - <?= $element['PROPERTY_PRICE_VALUE'] ?> - <?= $element['PROPERTY_MATERIAL_VALUE'] ?> - <?= $element['PROPERTY_ARTNUMBER_VALUE'] ?>
                            - <?= $element['DETAIL_PAGE_URL'] ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <? endif; ?>
        </li>
    <?php endforeach; ?>
</ul>