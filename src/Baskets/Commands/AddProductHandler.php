<?php namespace KBC\Baskets\Commands;

use KBC\Baskets\BasketRepository;

final class AddProductHandler
{
    private $repository;

    public function __construct(BasketRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(AddProduct $command)
    {
        $basket = $this->repository->load($command->getBasketId());

        $basket->addProduct($command->getItem());

        $this->repository->save($basket);
    }
}
