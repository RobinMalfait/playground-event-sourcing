<?php namespace KBC\Baskets\Events;

use KBC\EventSourcing\Events\DomainEvent;

final class BasketWasCreated implements DomainEvent
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getAggregateId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}
