<?php namespace KBC\Accounts\Commands;

use KBC\Accounts\Account;
use KBC\Accounts\AccountRepository;

final class OpenAccountHandler
{
    private $repository;

    public function __construct(AccountRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(OpenAccount $command)
    {
        $account = Account::open($command->getId(), $command->getName());

        $this->repository->save($account);
    }
}
