<?php namespace KBC\Baskets\Events;

use KBC\Baskets\VO\BasketId;
use KBC\Baskets\VO\ProductId;
use KBC\EventSourcing\Events\DomainEvent;

final class ProductWasDeletedFromBasket implements DomainEvent
{
    /** @var \KBC\Baskets\VO\BasketId */
    private $basketId;

    /** @var \KBC\Baskets\VO\ProductId */
    private $productId;

    public function __construct(BasketId $basketId, ProductId $productId)
    {
        $this->basketId = $basketId;
        $this->productId = $productId;
    }

    public function getAggregateId()
    {
        return $this->basketId;
    }

    public function getBasketId()
    {
        return $this->basketId;
    }

    public function getProductId()
    {
        return $this->productId;
    }
}
