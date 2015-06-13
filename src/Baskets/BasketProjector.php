<?php namespace KBC\Baskets;

use KBC\Baskets\Events\BasketWasCreated;
use KBC\Baskets\Events\ItemWasAddedToBasket;
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
            'items' => []
        ]);
    }

    public function projectItemWasAddedToBasket(ItemWasAddedToBasket $event)
    {
        $this->jsonDatabase->update($event->id, function ($row) use ($event) {
            $row['items'][] = $event->item;

            return $row;
        });
    }
}
