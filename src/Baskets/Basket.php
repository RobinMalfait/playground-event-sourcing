<?php namespace KBC\Baskets;

use KBC\Baskets\Events\BasketWasCreated;
use KBC\Core\BaseModel;

final class Basket extends BaseModel
{
    public $id;

    public $items;

    public static function create($id)
    {
        $me = new static();

        $me->apply(new BasketWasCreated($id, []));

        return $me;
    }

    public function applyBasketWasCreated(BasketWasCreated $event)
    {
        $this->id = $event->id;
        $this->items = $event->items;
    }
}
