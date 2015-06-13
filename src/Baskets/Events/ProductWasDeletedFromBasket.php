<?php namespace KBC\Baskets\Events;

use KBC\Baskets\VO\ProductId;
use KBC\EventSourcing\Events\DomainEvent;

final class ProductWasDeletedFromBasket implements DomainEvent
{
    private $basketId;

    private $productId;

    public function __construct($basketId, ProductId $productId)
    {
        $this->basketId = $basketId;
        $this->productId = $productId;
    }

    public function getAggregateId()
    {
        return $this->basketId;
    }

    /**
     * @return mixed
     */
    public function getBasketId()
    {
        return $this->basketId;
    }

    /**
     * @return ProductId
     */
    public function getProductId()
    {
        return $this->productId;
    }
}
