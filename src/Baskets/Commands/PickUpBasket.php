<?php namespace Acme\Baskets\Commands;

use Acme\Baskets\VO\BasketId;

final class PickUpBasket
{
    /** @var \Acme\Baskets\VO\BasketId */
    private $basketId;

    public function __construct(BasketId $basketId)
    {
        $this->basketId = $basketId;
    }

    public function getBasketId()
    {
        return $this->basketId;
    }
}
