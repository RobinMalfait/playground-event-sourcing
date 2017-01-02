<?php namespace KBC\Baskets\Commands;

use KBC\Baskets\Basket;
use KBC\Baskets\BasketRepository;

final class PickUpBasketHandler
{
    private $repository;

    public function __construct(BasketRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(PickUpBasket $command)
    {
        $basket = Basket::create($command->getId());

        $this->repository->save($basket);
    }
}
