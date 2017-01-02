<?php namespace KBC\Baskets\Commands;

use KBC\Baskets\Basket;
use KBC\Baskets\BasketRepository;

final class PickUpBasketHandler
{
    /** @var \KBC\Baskets\BasketRepository */
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
