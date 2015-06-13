<?php namespace KBC\Baskets\Events;

use KBC\Baskets\VO\Product;
use KBC\EventSourcing\Events\DomainEvent;

final class ProductWasAddedToBasket implements DomainEvent
{
    private $basketId;

    private $item;

    public function __construct($basketId, Product $item)
    {
        $this->basketId = $basketId;
        $this->item = $item;
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
     * @return Product
     */
    public function getItem()
    {
        return $this->item;
    }
}
