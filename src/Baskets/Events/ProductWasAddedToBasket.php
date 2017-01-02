<?php namespace KBC\Baskets\Events;

use KBC\Baskets\VO\BasketId;
use KBC\Baskets\VO\Product;
use KBC\EventSourcing\Events\DomainEvent;

final class ProductWasAddedToBasket implements DomainEvent
{
    /** @var \KBC\Baskets\VO\BasketId */
    private $basketId;

    /** @var \KBC\Baskets\VO\Product */
    private $item;

    public function __construct(BasketId $basketId, Product $item)
    {
        $this->basketId = $basketId;
        $this->item = $item;
    }

    public function getAggregateId()
    {
        return $this->basketId;
    }

    public function getBasketId()
    {
        return $this->basketId;
    }

    public function getItem()
    {
        return $this->item;
    }
}
