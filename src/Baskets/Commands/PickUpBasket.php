<?php namespace KBC\Baskets\Commands;

use KBC\Baskets\VO\BasketId;

final class PickUpBasket
{
    /** @var \KBC\Baskets\VO\BasketId */
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
