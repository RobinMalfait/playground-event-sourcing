<?php namespace KBC\Baskets;

use KBC\Baskets\Events\BasketWasCreated;
use KBC\Baskets\Events\ItemWasAddedToBasket;
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

    public function addItem(Item $item)
    {
        $this->apply(new ItemWasAddedToBasket($this->id, $item));
    }


    public function applyBasketWasCreated(BasketWasCreated $event)
    {
        $this->id = $event->id;
        $this->items = [];
    }

    public function applyItemWasAddedToBasket(ItemWasAddedToBasket $event)
    {
        $this->items[] = $event->item;
    }
}
