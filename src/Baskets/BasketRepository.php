<?php namespace KBC\Baskets;

use KBC\EventSourcing\EventSourcingRepository;

class BasketRepository
{
    protected $repository;

    public function __construct(EventSourcingRepository $repository)
    {
        $this->repository = $repository;
        $this->repository->setAggregateClass(Basket::class);
    }

    public function load($id)
    {
        return $this->repository->load($id);
    }

    public function save($aggregateRoot)
    {
        $this->repository->save($aggregateRoot);
    }
}
