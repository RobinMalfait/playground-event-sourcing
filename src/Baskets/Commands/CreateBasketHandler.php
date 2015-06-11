<?php namespace KBC\Baskets\Commands;

use KBC\Baskets\Basket;
use KBC\Baskets\BasketRepository;

class CreateBasketHandler
{
    protected $repository;

    public function __construct(BasketRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(CreateBasket $command)
    {
        $basket = Basket::create($command->id);

        $this->repository->save($basket);
    }
}
