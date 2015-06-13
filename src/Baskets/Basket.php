<?php namespace KBC\Baskets;

use KBC\Baskets\Events\BasketWasCreated;
use KBC\Baskets\Events\ProductWasAddedToBasket;
use KBC\Baskets\Events\ProductWasDeletedFromBasket;
use KBC\Core\BaseModel;

final class Basket extends BaseModel
{
    public $id;

    public $items;

    public static function create($id)
    {
        $me = new static();

        $me->apply(new BasketWasCreated($id));

        return $me;
    }

    public function addProduct(Product $item)
    {
        $this->apply(new ProductWasAddedToBasket($this->id, $item));
    }

    public function removeProduct(ProductId $productId)
    {
        $this->apply(new ProductWasDeletedFromBasket($this->id, $productId));
    }

    public function applyBasketWasCreated(BasketWasCreated $event)
    {
        $this->id = $event->id;
        $this->items = [];
    }

    public function applyProductWasAddedToBasket(ProductWasAddedToBasket $event)
    {
        $this->items[] = $event->item;
    }

    public function applyProductWasDeletedFromBasket(ProductWasDeletedFromBasket $event)
    {
        foreach ($this->items as $key => $item) {
            if ($item->productId == $event->productId) {
                unset($this->items[$key]);
            }
        }
    }
}
