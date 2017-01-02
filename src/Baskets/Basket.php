<?php namespace Acme\Baskets;

use Acme\Baskets\Events\BasketWasCreated;
use Acme\Baskets\Events\ProductWasAddedToBasket;
use Acme\Baskets\Events\ProductWasDeletedFromBasket;
use Acme\Baskets\VO\BasketId;
use Acme\Baskets\VO\Product;
use Acme\Baskets\VO\ProductId;
use Acme\Core\AggregateRoot;

final class Basket extends AggregateRoot
{

    /** @var \Acme\Baskets\VO\BasketId */
    public $id;

    /** @var array */
    public $items;

    public static function pickUp(BasketId $id)
    {
        $me = new static();

        $me->apply(new BasketWasCreated($id));

        return $me;
    }

    public function addProduct(Product $item)
    {
        $this->apply(new ProductWasAddedToBasket($this->id, $item));
    }

    public function removeProduct(ProductId $productId)
    {
        $this->apply(new ProductWasDeletedFromBasket($this->id, $productId));
    }

    public function applyBasketWasCreated(BasketWasCreated $event)
    {
        $this->id = $event->getBasketId();
        $this->items = [];
    }

    public function applyProductWasAddedToBasket(ProductWasAddedToBasket $event)
    {
        $this->items[] = $event->getItem();
    }

    public function applyProductWasDeletedFromBasket(ProductWasDeletedFromBasket $event)
    {
        foreach ($this->items as $key => $item) {
            if ($item->getProductId() == $event->getProductId()) {
                unset($this->items[$key]);
            }
        }
    }
}
