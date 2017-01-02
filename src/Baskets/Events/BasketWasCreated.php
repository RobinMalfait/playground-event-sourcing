<?php namespace KBC\Baskets\Events;

use KBC\Baskets\VO\BasketId;
use KBC\EventSourcing\Events\DomainEvent;

final class BasketWasCreated implements DomainEvent
{
    /** @var \KBC\Baskets\VO\BasketId */
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
