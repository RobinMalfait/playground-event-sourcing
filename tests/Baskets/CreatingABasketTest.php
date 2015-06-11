<?php namespace Test\Baskets;

use Command;
use KBC\Baskets\BasketRepository;
use KBC\Baskets\Commands\CreateBasket;
use KBC\Baskets\Commands\CreateBasketHandler;
use KBC\Baskets\Events\BasketWasCreated;
use Specification;

class CreatingABasketTest extends Specification
{
    /**
     * Given events
     *
     * @return array
     */
    public function given()
    {
        return [];
    }

    /**
     * @return Command
     */
    public function when()
    {
        return new CreateBasket(123);
    }

    /**
     * @param $repository
     * @return mixed
     */
    public function handler($repository)
    {
        return new CreateBasketHandler(new BasketRepository($repository));
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
    public function an_basket_was_created_event_was_produced()
    {
        $this->assertInstanceOf(BasketWasCreated::class, $this->producedEvents[0]);
    }
}
