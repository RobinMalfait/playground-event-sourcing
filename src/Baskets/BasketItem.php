<?php namespace KBC\Baskets;

class BasketItem
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
}
