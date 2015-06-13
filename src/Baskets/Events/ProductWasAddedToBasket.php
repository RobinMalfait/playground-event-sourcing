<?php namespace KBC\Baskets\Events;

use KBC\Baskets\Product;
use KBC\EventSourcing\Events\DomainEvent;

final class ProductWasAddedToBasket implements DomainEvent
{
    public $basketId;
    public $item;

    public function __construct($basketId, Product $item)
    {
        $this->basketId = $basketId;
        $this->item = $item;
    }

    public function getAggregateId()
    {
        return $this->basketId;
    }
}
