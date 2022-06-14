<?php

namespace YLab\Components;

use Bitrix\Main\Context;
use Bitrix\Main\Loader;
use Bitrix\Sale\Fuser;
use CBitrixComponent;
use Bitrix\Sale\Basket;
use Bitrix\Currency\CurrencyManager;
use Bitrix\Main\Application;


/**
 * Class PromoComponent
 * @package YLab\Components
 * Компонент отображения списка элементов нашего ИБ
 */
class PromoComponent extends CBitrixComponent
{
    /** @var int $totalCost Минимальная сумма заказа в корзине */
    private $totalCost = 1500;

    /** @var int $productId ID продукта */
    private $productId = 323;

    /**
     * Метод executeComponent
     *
     * @return mixed|void
     * @throws Exception
     */
    public function executeComponent()
    {
        Loader::includeModule("catalog");

        $basket = Basket::loadItemsForFUser(Fuser::getId(), Context::getCurrent()->getSite());

        $basketItems = $basket->getBasketItems();

        $request = Application::getInstance()->getContext()->getRequest();

        if ($request->isPost() && !empty($request->get('getGifts'))) {
            if ((int)$request->get('count') > 0) {
                $this->addProductToBasket($basket, (int)$request->get('count'));
            }
        } else {
            // Если в корзине есть минимум 3 товара с ценой более 500р, то добавим в корзину пользователя товар
            $this->checkAddGiftsProduct($basketItems, $basket);
        }

        $this->arResult['BASKET_ITEMS'] = $basketItems;

        $this->arResult['IF_PROMO'] = $this->checkIfGivePromo($basket->getPrice());

        $this->includeComponentTemplate();
    }

    /**
     * Определим может ли пользователь участвовать в промо акции
     * @param float $total
     * @return bool
     */
    public function checkIfGivePromo(float $total): bool
    {
        return $total > $this->totalCost;
    }

    /**
     * Если в корзине есть минимум 3 товара с ценой более 500р, то добавим в корзину пользователя товар
     * @param array $basketItems
     * @param object $basket
     */
    private function checkAddGiftsProduct(array $basketItems, object $basket): void
    {
        $countProduct = 0;
        foreach ($basketItems as $basketItem) {
            if ($basketItem->getPrice() > 500) {
                $countProduct++;
            }
        }

        if ($countProduct >= 3) {
            $this->addProductToBasket($basket);
        }
    }

    /**
     * Добавление товара в корзину
     * @param object $basket
     * @param int $quantity
     */
    private function addProductToBasket(object $basket, int $quantity = 1): void
    {
        if ($item = $basket->getExistsItem('catalog', $this->productId)) {
            $item->setField('QUANTITY', $item->getQuantity() + $quantity);
        } else {
            $item = $basket->createItem('catalog', $this->productId);
            $item->setFields([
                'QUANTITY' => 1,
                'CURRENCY' => CurrencyManager::getBaseCurrency(),
                'LID' => Context::getCurrent()->getSite(),
                'PRICE' => 0,
            ]);
        }

        $basket->save();
    }
}
