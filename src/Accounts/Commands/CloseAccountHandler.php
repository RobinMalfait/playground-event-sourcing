<?php namespace KBC\Accounts\Commands;

use KBC\Accounts\AccountRepository;

class CloseAccountHandler
{
    protected $repository;

    public function __construct(AccountRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(CloseAccount $command)
    {
        $account = $this->repository->load($command->id);

        $account->close();

        $this->repository->save($account);
    }
}
