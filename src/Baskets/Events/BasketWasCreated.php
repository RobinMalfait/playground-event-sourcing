<?php namespace KBC\Baskets\Events;

use KBC\EventSourcing\Events\DomainEvent;

final class BasketWasCreated implements DomainEvent
{
    public $id;

    public $items;

    public function __construct($id, $items)
    {
        $this->id = $id;
        $this->items = $items;
    }
}
