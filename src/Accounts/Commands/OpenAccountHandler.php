<?php namespace Acme\Accounts\Commands;

use Acme\Accounts\Account;
use Acme\Accounts\AccountRepository;

final class OpenAccountHandler
{
    /** @var \Acme\Accounts\AccountRepository */
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
