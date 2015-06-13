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
     * Given events to build the aggregate
     *
     * @return array
     */
    public function given()
    {
        return [];
    }

    /**
     * Command to fire
     *
     * @return Command
     */
    public function when()
    {
        return new CreateBasket(123);
    }

    /**
     * The command handler
     *
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
    public function a_BasketWasCreated_event_was_produced()
    {
        $this->assertInstanceOf(BasketWasCreated::class, $this->producedEvents[0]);
    }
}
