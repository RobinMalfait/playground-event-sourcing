<?php namespace Test\Baskets;

use Command;
use KBC\Baskets\BasketRepository;
use KBC\Baskets\Commands\AddItem;
use KBC\Baskets\Commands\AddItemHandler;
use KBC\Baskets\Events\BasketWasCreated;
use KBC\Baskets\Events\ItemWasAddedToBasket;
use KBC\Baskets\Item;
use Specification;

class AddingAnItemToBasketTest extends Specification
{
    /**
     * Given events
     *
     * @return array
     */
    public function given()
    {
        return [
            new BasketWasCreated(123)
        ];
    }

    /**
     * @return Command
     */
    public function when()
    {
        return new AddItem(123, new Item('Test Item'));
    }

    /**
     * @param $repository
     * @return mixed
     */
    public function handler($repository)
    {
        return new AddItemHandler(new BasketRepository($repository));
    }

    /**
     * @test
     */
    public function one_event_has_been_produced()
    {
        $this->assertCount(1, $this->producedEvents);
    }

    /**
     * @test
     */
    public function a_ItemWasAddedToBasket_event_was_produced()
    {
        $this->assertInstanceOf(ItemWasAddedToBasket::class, $this->producedEvents[0]);
    }
}
