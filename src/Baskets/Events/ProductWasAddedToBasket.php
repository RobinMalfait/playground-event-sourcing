<?php namespace Acme\Baskets\Events;

use Acme\Baskets\VO\BasketId;
use Acme\Baskets\VO\Product;
use Acme\EventSourcing\Events\DomainEvent;

final class ProductWasAddedToBasket implements DomainEvent
{
    /** @var \Acme\Baskets\VO\BasketId */
    private $basketId;

    /** @var \Acme\Baskets\VO\Product */
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
