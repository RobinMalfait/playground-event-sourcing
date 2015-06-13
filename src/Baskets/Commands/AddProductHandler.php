<?php namespace KBC\Baskets\Commands;

use KBC\Baskets\BasketRepository;

final class AddProductHandler
{
    protected $repository;

    public function __construct(BasketRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(AddProduct $command)
    {
        $basket = $this->repository->load($command->basketId);

        $basket->addProduct($command->item);

        $this->repository->save($basket);
    }
}
