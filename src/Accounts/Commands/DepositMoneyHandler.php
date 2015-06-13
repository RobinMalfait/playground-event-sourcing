<?php namespace KBC\Accounts\Commands;

use KBC\Accounts\AccountRepository;

final class DepositMoneyHandler
{
    private $repository;

    public function __construct(AccountRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(DepositMoney $command)
    {
        $account = $this->repository->load($command->getId());

        $account->deposit($command->getBalance());

        $this->repository->save($account);
    }
}
