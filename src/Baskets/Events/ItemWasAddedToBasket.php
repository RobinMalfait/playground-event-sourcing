<?php namespace KBC\Baskets\Events;

use KBC\Baskets\Item;
use KBC\EventSourcing\Events\DomainEvent;

final class ItemWasAddedToBasket implements DomainEvent
{
    public $id;
    public $item;

    public function __construct($id, Item $item)
    {
        $this->id = $id;
        $this->item = $item;
    }
}
