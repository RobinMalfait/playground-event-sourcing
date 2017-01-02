<?php namespace Acme\Baskets\Commands;

use Acme\Baskets\VO\BasketId;
use Acme\Baskets\VO\Product;

final class AddProduct
{
    /** @var \Acme\Baskets\VO\BasketId */
    private $basketId;

    /** @var \Acme\Baskets\VO\Product */
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
