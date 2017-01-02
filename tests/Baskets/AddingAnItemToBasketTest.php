<?php namespace Test\Baskets;

use Command;
use KBC\Baskets\BasketRepository;
use KBC\Baskets\Commands\AddProduct;
use KBC\Baskets\Commands\AddProductHandler;
use KBC\Baskets\Events\BasketWasCreated;
use KBC\Baskets\Events\ProductWasAddedToBasket;
use KBC\Baskets\VO\BasketId;
use KBC\Baskets\VO\Product;
use KBC\Baskets\VO\ProductId;
use Specification;

class AddingAnItemToBasketTest extends Specification
{
    /**
     * Given events to build the aggregate
     *
     * @return array
     */
    public function given()
    {
        return [
            new BasketWasCreated(BasketId::fromString("123"))
        ];
    }

    /**
     * Command to fire
     *
     * @return Command
     */
    public function when()
    {
        return new AddProduct(BasketId::fromString("123"), new Product(ProductId::fromString('TestId'), 'Test Item'));
    }

    /**
     * The command handler
     *
     * @param $repository
     * @return mixed
     */
    public function handler($repository)
    {
        return new AddProductHandler(new BasketRepository($repository));
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
    public function a_ProductWasAddedToBasket_event_was_produced()
    {
        $this->assertInstanceOf(ProductWasAddedToBasket::class, $this->producedEvents[0]);
    }
}
