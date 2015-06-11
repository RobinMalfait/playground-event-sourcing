<?php namespace KBC\Baskets;

use KBC\Baskets\Events\BasketWasCreated;
use KBC\Storages\JsonDatabase;

final class BasketProjector
{
    protected $jsonDatabase;

    public function __construct(JsonDatabase $jsonDatabase)
    {
        $this->jsonDatabase = $jsonDatabase;
    }

    public function projectBasketWasCreated(BasketWasCreated $event)
    {
        $this->jsonDatabase->insert([
            'id' => $event->id,
            'items' => $event->items
        ]);
    }
}
