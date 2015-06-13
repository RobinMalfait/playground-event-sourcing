<?php namespace KBC\Baskets\Commands;

use KBC\Baskets\Product;

final class AddProduct
{
    public $basketId;

    public $item;

    public function __construct($basketId, Product $item)
    {
        $this->basketId = $basketId;
        $this->item = $item;
    }
}
