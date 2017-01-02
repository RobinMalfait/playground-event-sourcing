<?php namespace KBC\Baskets;

use KBC\Baskets\Events\BasketWasCreated;
use KBC\Baskets\Events\ProductWasAddedToBasket;
use KBC\Baskets\Events\ProductWasDeletedFromBasket;
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
            'id' => $event->getBasketId()->getId(),
            'items' => []
        ]);
    }

    public function projectProductWasAddedToBasket(ProductWasAddedToBasket $event)
    {
        $this->jsonDatabase->update($event, function ($row) use ($event) {
            $row['items'][] = [
                'productId' => $event->getItem()->getProductId()->getId(),
                'name' => $event->getItem()->getName()
            ];

            return $row;
        });
    }

    public function projectProductWasDeletedFromBasket(ProductWasDeletedFromBasket $event)
    {
        $this->jsonDatabase->update($event, function ($row) use ($event) {
            foreach ($row['items'] as $key => $item) {
                if ($item['productId'] == $event->getProductId()->getId()) {
                    unset($row['items'][$key]);
                }
            }

            $row['items'] = array_values($row['items']);
            return $row;
        });
    }
}
