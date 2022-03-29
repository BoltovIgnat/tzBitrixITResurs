<b>Каталог:</b>
<ul>
<?foreach($arResult["ITEMS"] as $key => $arItem):
    $sections = '';
    foreach ($arItem['SECTIONS'] as $arSection) {
        $sections = $sections.''.$arSection['NAME'].',';
    }
    $sections = substr($sections,0,-1);
    ?>
    <li><?=$arResult["NEWS"][$key]['NAME']?> - <?=$arResult["NEWS"][$key]['DATE_CREATE']->toString(new \Bitrix\Main\Context\Culture(array("FORMAT_DATETIME" => "d.m.Y")))?> (<?=$sections?>)

        <ul>
            <?foreach($arItem["PRODUCTS"] as $arProduct):?>
                <li>
                    <?=$arProduct['NAME'].' - '.$arProduct['PRICE'].' - '.$arProduct['MATERIAL'].' - '.$arProduct['ARTNUMBER']?>
                </li>
            <?endforeach;?>
        </ul>

    </li>


<?endforeach;?>
</ul>
