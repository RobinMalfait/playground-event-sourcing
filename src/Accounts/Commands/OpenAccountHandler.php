<?php namespace KBC\Accounts\Commands;

use KBC\Accounts\Account;
use KBC\Accounts\AccountRepository;

final class OpenAccountHandler
{
    /** @var \KBC\Accounts\AccountRepository */
    private $repository;

    public function __construct(AccountRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(OpenAccount $command)
    {
        $account = Account::open(
            $command->getAccountId(),
            $command->getName()
        );

        $this->repository->save($account);
    }
}
