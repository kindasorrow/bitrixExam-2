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
                <?
                    $this->AddEditAction("add_element", $arResult['ADD_LINK'], CIBlock::GetArrayByID($news["IBLOCK_ID"], "ELEMENT_ADD"));
                ?>
                <ul id="<?= $this->GetEditAreaId("add_element")?>">
                    <?php foreach ($news['ELEMENTS'] as $element): ?>
                        <?
                        $this->AddEditAction($news['ID']. '-' . $element['ID'], $element['EDIT_LINK'], CIBlock::GetArrayByID($element["IBLOCK_ID"], "ELEMENT_EDIT"));
                        $this->AddDeleteAction($news['ID']. '-' .$element['ID'], $element['DELETE_LINK'], CIBlock::GetArrayByID($element["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                        ?>
                        <li>
                            <span
                                    id="<?=$this->GetEditAreaId($news['ID']. '-' . $element['ID'])?>"
                            ><?= $element['NAME'] ?> - <?= $element['PROPERTY_PRICE_VALUE'] ?> - <?= $element['PROPERTY_MATERIAL_VALUE'] ?> - <?= $element['PROPERTY_ARTNUMBER_VALUE'] ?>
                            - <?= $element['DETAIL_PAGE_URL'] ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <? endif; ?>
        </li>
    <?php endforeach; ?>
</ul>