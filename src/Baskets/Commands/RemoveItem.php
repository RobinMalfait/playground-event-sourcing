<?php namespace KBC\Baskets\Commands;

use KBC\Baskets\VO\BasketId;
use KBC\Baskets\VO\ProductId;

final class RemoveItem
{
    /** @var \KBC\Baskets\VO\BasketId */
    private $basketId;

    /** @var \KBC\Baskets\VO\ProductId */
    private $productId;

    public function __construct(BasketId $basketId, ProductId $productId)
    {
        $this->basketId = $basketId;
        $this->productId = $productId;
    }

    public function getBasketId()
    {
        return $this->basketId;
    }

    public function getProductId()
    {
        return $this->productId;
    }
}
