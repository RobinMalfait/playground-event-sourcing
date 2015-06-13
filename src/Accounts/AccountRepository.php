<?php namespace KBC\Accounts;

use KBC\EventSourcing\EventSourcingRepository;

final class AccountRepository
{
    private $repository;

    public function __construct(EventSourcingRepository $repository)
    {
        $this->repository = $repository;
        $this->repository->setAggregateClass(Account::class);
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
