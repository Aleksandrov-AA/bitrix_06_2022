<?php

namespace Sprint\Migration;


use Bitrix\Catalog\Controller\Product;
use Bitrix\Catalog\ProductTable;
use Bitrix\Main\Loader;

class AddProduct20220608173756 extends Version
{
    protected $description = "Добавление товара \"Подарок\"";

    protected $moduleVersion = "4.0.6";

    /**
     * @return bool|void
     * @throws Exceptions\ExchangeException
     * @throws \Bitrix\Main\LoaderException
     */
    public function up()
    {
        Loader::includeModule("catalog");

        $helper = $this->getHelperManager();

        $iblockId = $helper->Iblock()->getIblockId('clothes');

        $sectionId = $helper->Iblock()->getSection($iblockId, 'accessories')['ID'];

        $product = new Product();

        $productFields = [
            'IBLOCK_ID' => $iblockId,
            'IBLOCK_SECTION_ID' => $sectionId,
            'CODE' => 'GIFTS',
            'NAME' => 'Подарок',
            'QUANTITY_TRACE' => 'N',
            'AVAILABLE' => 'Y',
            'TYPE' => ProductTable::TYPE_PRODUCT,
        ];


        $productID = $product->addAction($productFields);

        $this->saveData('ProductGifts', $productID);
    }

    /**
     * @return bool|void
     * @throws Exceptions\ExchangeException
     * @throws \Bitrix\Main\LoaderException
     */
    public function down()
    {
/*        Loader::includeModule("catalog");

        $product = new Product();

        $productID = $this->getSavedData('ProductGifts');

        $product->deleteAction($productID);*/
    }
}
