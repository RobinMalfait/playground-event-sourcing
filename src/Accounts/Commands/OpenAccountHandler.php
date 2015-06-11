<?php namespace KBC\Accounts\Commands;

use KBC\Accounts\Account;
use KBC\Accounts\AccountRepository;

class OpenAccountHandler
{
    protected $repository;

    public function __construct(AccountRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(OpenAccount $command)
    {
        $account = Account::open($command->id, $command->name);

        $this->repository->save($account);
    }
}
