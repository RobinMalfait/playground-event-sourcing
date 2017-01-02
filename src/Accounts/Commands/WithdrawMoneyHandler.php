<?php namespace Acme\Accounts\Commands;

use Acme\Accounts\AccountRepository;

final class WithdrawMoneyHandler
{
    /** @var \Acme\Accounts\AccountRepository */
    private $repository;

    public function __construct(AccountRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(WithdrawMoney $command)
    {
        $account = $this->repository->load(
            $command->getAccountId()->getId()
        );

        $account->withdraw($command->getBalance());

        $this->repository->save($account);
    }
}
