<?php namespace KBC\Baskets\Commands;

use KBC\Baskets\ProductId;

final class RemoveItem
{
    public $basketId;

    public $productId;

    public function __construct($basketId, ProductId $productId)
    {
        $this->basketId = $basketId;
        $this->productId = $productId;
    }
}
