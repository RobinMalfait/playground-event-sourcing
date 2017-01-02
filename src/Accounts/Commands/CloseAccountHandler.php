<?php namespace Acme\Accounts\Commands;

use Acme\Accounts\AccountRepository;

final class CloseAccountHandler
{

    /** @var \Acme\Accounts\AccountRepository */
    private $repository;

    public function __construct(AccountRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(CloseAccount $command)
    {
        $account = $this->repository->load(
            $command->getAccountId()->getId()
        );

        $account->close();

        $this->repository->save($account);
    }
}
