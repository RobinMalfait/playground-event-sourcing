<?php namespace Acme\Baskets\Commands;

use Acme\Baskets\Basket;
use Acme\Baskets\BasketRepository;

final class PickUpBasketHandler
{
    /** @var \Acme\Baskets\BasketRepository */
    private $repository;

    public function __construct(BasketRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(PickUpBasket $command)
    {
        $basket = Basket::pickUp($command->getBasketId());

        $this->repository->save($basket);
    }
}
