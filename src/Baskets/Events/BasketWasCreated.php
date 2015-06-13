<?php namespace KBC\Baskets\Events;

use KBC\EventSourcing\Events\DomainEvent;

final class BasketWasCreated implements DomainEvent
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
}
