<?php namespace Acme\Baskets\Events;

use Acme\Baskets\VO\BasketId;
use Acme\EventSourcing\Events\DomainEvent;

final class BasketWasCreated implements DomainEvent
{
    /** @var \Acme\Baskets\VO\BasketId */
    private $basketId;

    public function __construct(BasketId $basketId)
    {
        $this->basketId = $basketId;
    }

    public function getAggregateId()
    {
        return $this->basketId->getId();
    }

    public function getBasketId()
    {
        return $this->basketId;
    }
}
