<?php namespace KBC\Accounts\Commands;

use KBC\Accounts\Account;
use KBC\EventSourcing\EventSourcingRepository;

class WithdrawMoneyHandler
{
    protected $repository;

    public function __construct(EventSourcingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(WithdrawMoney $command)
    {
        $account = Account::replayEvents(
            $this->repository->load($command->id)
        );

        $account->withdraw($command->amount);

        $this->repository->save($account);
    }
}
