<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

?>
<div class="news-list">
    <?php foreach ($arResult['ITEMS'] as $arItem) { ?>
        <p class="news-item" id="">
            <b>ФИО клиента:</b> <?= $arItem['PROPERTIES']['NAME']['VALUE'] ?>
            (тел. <?= $arItem['PROPERTIES']['PHONE']['VALUE'] ?>)
        </p>
        <p class="news-item" id="">
            <b>Адрес клиента:</b><br>
            <?= $arItem['PROPERTY_ADDRESS_PROPERTY_CITY_VALUE'] ?><br>
            <?= $arItem['PROPERTY_ADDRESS_PROPERTY_STREET_VALUE'] ?> <?= $arItem['PROPERTY_ADDRESS_PROPERTY_HOUSE_VALUE'] ?>
            / <?= $arItem['PROPERTY_ADDRESS_PROPERTY_APARTMENT_VALUE'] ?>
        </p>
    <?php } ?>
</div>
