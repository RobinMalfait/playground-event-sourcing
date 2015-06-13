<?php namespace KBC\Baskets\Commands;

use KBC\Baskets\BasketRepository;

final class AddItemHandler
{
    protected $repository;

    public function __construct(BasketRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(AddItem $command)
    {
        $basket = $this->repository->load($command->basketId);

        $basket->addItem($command->item);

        $this->repository->save($basket);
    }
}
