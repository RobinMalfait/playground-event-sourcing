<?php namespace Acme\Baskets\Commands;

use Acme\Baskets\BasketRepository;

final class RemoveItemHandler
{
    /** @var \Acme\Baskets\BasketRepository */
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
