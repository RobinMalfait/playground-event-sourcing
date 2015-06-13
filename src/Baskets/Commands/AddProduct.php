<?php namespace KBC\Baskets\Commands;

use KBC\Baskets\VO\Product;

final class AddProduct
{
    private $basketId;

    private $item;

    public function __construct($basketId, Product $item)
    {
        $this->basketId = $basketId;
        $this->item = $item;
    }

    /**
     * @return mixed
     */
    public function getBasketId()
    {
        return $this->basketId;
    }

    /**
     * @return Product
     */
    public function getItem()
    {
        return $this->item;
    }
}
