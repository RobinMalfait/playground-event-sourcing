<?php namespace KBC\Accounts\Commands;

use KBC\Accounts\Account;
use KBC\EventSourcing\EventSourcingRepository;

class DepositMoneyHandler
{
    protected $repository;

    public function __construct(EventSourcingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(DepositMoney $command)
    {
        $account = Account::replayEvents(
            $this->repository->load($command->id)
        );

        $account->deposit($command->amount);

        $this->repository->save($account);
    }
}
