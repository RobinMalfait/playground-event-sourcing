<?php namespace KBC\Accounts\Commands;

use KBC\Accounts\AccountRepository;

final class CloseAccountHandler
{
    private $repository;

    public function __construct(AccountRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(CloseAccount $command)
    {
        $account = $this->repository->load($command->getId());

        $account->close();

        $this->repository->save($account);
    }
}
