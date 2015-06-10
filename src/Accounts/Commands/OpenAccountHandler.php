<?php namespace KBC\Accounts\Commands;

use KBC\Accounts\Account;
use KBC\EventSourcing\EventSourcingRepository;

class OpenAccountHandler
{
    protected $repository;

    public function __construct(EventSourcingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(OpenAccount $command)
    {
        $account = Account::open($command->id, $command->name);

        $this->repository->save($account);
    }
}
