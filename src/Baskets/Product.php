<?php namespace KBC\Baskets;

class Product
{
    public $productId;
    public $name;

    public function __construct(ProductId $productId, $name)
    {
        $this->productId = $productId;
        $this->name = $name;
    }
}
