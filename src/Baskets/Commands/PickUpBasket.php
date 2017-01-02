<?php namespace Acme\Baskets\Commands;

use Acme\Baskets\VO\BasketId;

final class PickUpBasket
{
    /** @var \Acme\Baskets\VO\BasketId */
    private $basketId;

    private function __construct(BasketId $basketId)
    {
        $this->basketId = $basketId;
    }

    public static function withId(BasketId $basketId)
    {
        return new self($basketId);
    }

    public function getBasketId()
    {
        return $this->basketId;
    }
}
