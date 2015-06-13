<?php namespace KBC\Baskets\Commands;

use KBC\Baskets\Item;

final class AddItem
{
    public $basketId;

    public $item;

    public function __construct($basketId, Item $item)
    {
        $this->basketId = $basketId;
        $this->item = $item;
    }
}
