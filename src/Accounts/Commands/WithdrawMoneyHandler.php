<?php namespace KBC\Accounts\Commands;

use KBC\Accounts\AccountRepository;

final class WithdrawMoneyHandler
{
    private $repository;

    public function __construct(AccountRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(WithdrawMoney $command)
    {
        $account = $this->repository->load($command->getId());

        $account->withdraw($command->getBalance());

        $this->repository->save($account);
    }
}
