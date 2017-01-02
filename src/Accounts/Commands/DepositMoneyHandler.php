<?php namespace Acme\Accounts\Commands;

use Acme\Accounts\AccountRepository;

final class DepositMoneyHandler
{

    /** @var \Acme\Accounts\AccountRepository */
    private $repository;

    public function __construct(AccountRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(DepositMoney $command)
    {
        $account = $this->repository->load(
            $command->getAccountId()->getId()
        );

        $account->deposit($command->getBalance());

        $this->repository->save($account);
    }
}
