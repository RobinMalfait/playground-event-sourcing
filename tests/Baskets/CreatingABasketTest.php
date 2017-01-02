<?php namespace Test\Baskets;

use Command;
use KBC\Baskets\BasketRepository;
use KBC\Baskets\Commands\PickUpBasket;
use KBC\Baskets\Commands\PickUpBasketHandler;
use KBC\Baskets\Events\BasketWasCreated;
use KBC\Baskets\VO\BasketId;
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
        return new PickUpBasket(BasketId::fromString("123"));
    }

    /**
     * The command handler
     *
     * @param $repository
     * @return mixed
     */
    public function handler($repository)
    {
        return new PickUpBasketHandler(new BasketRepository($repository));
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
