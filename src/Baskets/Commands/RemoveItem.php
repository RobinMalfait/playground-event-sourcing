<?php namespace KBC\Baskets\Commands;

use KBC\Baskets\VO\ProductId;

final class RemoveItem
{
    private $basketId;

    private $productId;

    public function __construct($basketId, ProductId $productId)
    {
        $this->basketId = $basketId;
        $this->productId = $productId;
    }

    /**
     * @return mixed
     */
    public function getBasketId()
    {
        return $this->basketId;
    }

    /**
     * @return ProductId
     */
    public function getProductId()
    {
        return $this->productId;
    }
}
