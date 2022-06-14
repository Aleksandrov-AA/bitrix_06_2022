<?php require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

use Ylab\Helpers;

/** @var CAllMain $APPLICATION */
$APPLICATION->SetTitle("Lesson 1");
?>

<?php
$APPLICATION->IncludeComponent(
    'bitrix:news.list',
    'clients',
    [
        'IBLOCK_TYPE' => 'contacts',
        'IBLOCK_ID' => Helpers::getIBlockIdByCode('contacts'),

        'PROPERTY_CODE' => ['NAME', 'PHONE', 'ADDRESS'],
        'FIELD_CODE' => [
            'PROPERTY_ADDRESS.PROPERTY_CITY',
            'PROPERTY_ADDRESS.PROPERTY_STREET',
            'PROPERTY_ADDRESS.PROPERTY_HOUSE',
            'PROPERTY_ADDRESS.PROPERTY_APARTMENT'
        ],
    ]
);
?>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php'; ?>

