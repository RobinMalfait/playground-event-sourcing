<?php namespace KBC\Baskets\Events;

use KBC\Baskets\ProductId;
use KBC\EventSourcing\Events\DomainEvent;

class ProductWasDeletedFromBasket implements DomainEvent
{
    public $basketId;

    public $productId;

    public function __construct($basketId, ProductId $productId)
    {
        $this->basketId = $basketId;
        $this->productId = $productId;
    }


    public function getAggregateId()
    {
        return $this->basketId;
    }
}
