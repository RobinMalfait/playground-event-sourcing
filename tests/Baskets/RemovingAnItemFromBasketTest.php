<?php namespace Test\Baskets;

use KBC\Baskets\BasketRepository;
use KBC\Baskets\Commands\RemoveItem;
use KBC\Baskets\Commands\RemoveItemHandler;
use KBC\Baskets\Events\BasketWasCreated;
use KBC\Baskets\Events\ProductWasAddedToBasket;
use KBC\Baskets\Events\ProductWasDeletedFromBasket;
use KBC\Baskets\VO\BasketId;
use KBC\Baskets\VO\Product;
use KBC\Baskets\VO\ProductId;
use Specification;

class RemovingAnItemFromBasketTest extends Specification
{
    /**
     * Given events to build the aggregate
     *
     * @return array
     */
    public function given()
    {
        return [
            new BasketWasCreated(BasketId::fromString("123")),
            new ProductWasAddedToBasket(BasketId::fromString("123"), new Product(ProductId::fromString('321'), "Test Product"))
        ];
    }

    /**
     * Command to fire
     *
     * @return Command
     */
    public function when()
    {
        return new RemoveItem(BasketId::fromString("123"), ProductId::fromString('321'));
    }

    /**
     * The command handler
     *
     * @param $repository
     * @return mixed
     */
    public function handler($repository)
    {
        return new RemoveItemHandler(new BasketRepository($repository));
    }

    /**
     * @test
     */
    public function one_event_was_produced()
    {
        $this->assertCount(1, $this->producedEvents);
    }

    /**
     * @test
     */
    public function a_ProductWasDeletedFromBasket_event_was_produced()
    {
        $this->assertInstanceOf(ProductWasDeletedFromBasket::class, $this->producedEvents[0]);
    }

    /**
     * @test
     */
    public function there_are_no_items_in_the_basket()
    {
        $this->assertCount(0, $this->aggregate->items);
    }
}
