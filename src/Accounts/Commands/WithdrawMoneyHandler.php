<?php namespace KBC\Accounts\Commands;

use KBC\Accounts\AccountRepository;

final class WithdrawMoneyHandler
{
    /** @var \KBC\Accounts\AccountRepository */
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
