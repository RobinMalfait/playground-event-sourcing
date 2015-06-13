<?php namespace KBC\Baskets\Commands;

use KBC\Baskets\BasketRepository;

class RemoveItemHandler
{
    protected $repository;

    public function __construct(BasketRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(RemoveItem $command)
    {
        $basket = $this->repository->load($command->basketId);

        $basket->removeProduct($command->productId);

        $this->repository->save($basket);
    }
}
