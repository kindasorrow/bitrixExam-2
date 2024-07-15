<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>


<ul>
    <?foreach($arResult["USER_NEWS"] as $arItem):?>
        <li>[<?=$arItem["ID"]?>] - <?=$arItem["LOGIN"]?></li>
        <ul>
            <?foreach($arItem["NEWS"] as $arNewsItem):?>
                <li><?=$arNewsItem["ACTIVE_FROM"]?> - <?=$arNewsItem["NAME"]?></li>
            <?endforeach;?>
    <?endforeach;?>
</ul>