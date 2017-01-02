<?php namespace KBC\Baskets\Commands;

use KBC\Baskets\VO\BasketId;
use KBC\Baskets\VO\Product;

final class AddProduct
{
    /** @var \KBC\Baskets\VO\BasketId */
    private $basketId;

    /** @var \KBC\Baskets\VO\Product */
    private $item;

    public function __construct(BasketId $basketId, Product $item)
    {
        $this->basketId = $basketId;
        $this->item = $item;
    }

    public function getBasketId()
    {
        return $this->basketId;
    }

    public function getItem()
    {
        return $this->item;
    }
}
