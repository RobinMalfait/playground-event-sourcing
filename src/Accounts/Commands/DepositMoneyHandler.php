<?php namespace KBC\Accounts\Commands;

use KBC\Accounts\AccountRepository;

class DepositMoneyHandler
{
    protected $repository;

    public function __construct(AccountRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(DepositMoney $command)
    {
        $account = $this->repository->load($command->id);

        $account->deposit($command->balance);

        $this->repository->save($account);
    }
}
