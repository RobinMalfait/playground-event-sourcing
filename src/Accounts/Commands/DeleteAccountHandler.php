<?php namespace KBC\Accounts\Commands;

use KBC\Accounts\Account;
use KBC\EventSourcing\EventSourcingRepository;

class DeleteAccountHandler
{
    protected $repository;

    public function __construct(EventSourcingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(DeleteAccount $command)
    {
        $account = Account::replayEvents(
            $this->repository->load($command->id)
        );

        $account->delete();

        $this->repository->save($account);
    }
}
