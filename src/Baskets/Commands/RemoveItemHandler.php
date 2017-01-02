<?php namespace KBC\Baskets\Commands;

use KBC\Baskets\BasketRepository;

final class RemoveItemHandler
{
    /** @var \KBC\Baskets\BasketRepository */
    private $repository;

    public function __construct(BasketRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(RemoveItem $command)
    {
        $basket = $this->repository->load($command->getBasketId()->getId());

        $basket->removeProduct($command->getProductId());

        $this->repository->save($basket);
    }
}
