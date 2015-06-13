<?php namespace KBC\Baskets\Commands;

use KBC\Baskets\Basket;
use KBC\Baskets\BasketRepository;

final class CreateBasketHandler
{
    private $repository;

    public function __construct(BasketRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(CreateBasket $command)
    {
        $basket = Basket::create($command->getId());

        $this->repository->save($basket);
    }
}
