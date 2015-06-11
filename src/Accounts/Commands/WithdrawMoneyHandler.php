<?php namespace KBC\Accounts\Commands;

use KBC\Accounts\AccountRepository;

class WithdrawMoneyHandler
{
    protected $repository;

    public function __construct(AccountRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(WithdrawMoney $command)
    {
        $account = $this->repository->load($command->id);

        $account->withdraw($command->balance);

        $this->repository->save($account);
    }
}
