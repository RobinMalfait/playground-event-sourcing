<?php namespace Acme\Baskets\Commands;

use Acme\Baskets\VO\BasketId;
use Acme\Baskets\VO\ProductId;

final class RemoveItem
{
    /** @var \Acme\Baskets\VO\BasketId */
    private $basketId;

    /** @var \Acme\Baskets\VO\ProductId */
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
