<?php namespace KBC\Accounts;

use KBC\Accounts\Events\AccountWasDeleted;
use KBC\Accounts\Events\AccountWasOpened;
use KBC\Accounts\Events\MoneyHasBeenCollected;
use KBC\Accounts\Events\MoneyWasDeposited;
use KBC\Storages\JsonDatabase;

final class AccountProjector
{
    protected $jsonDatabase;

    public function __construct(JsonDatabase $jsonDatabase)
    {
        $this->jsonDatabase = $jsonDatabase;
    }

    public function projectAccountWasOpened(AccountWasOpened $event)
    {
        $this->jsonDatabase->insert([
            'id' => $event->id,
            'name' => $event->name->getFullName(),
            'balance' => $event->balance
        ]);
    }

    public function projectMoneyWasDeposited(MoneyWasDeposited $event)
    {
        $this->jsonDatabase->update($event->accountId, function ($row) use ($event) {
            $row['balance'] += $event->amount;

            return $row;
        });
    }

    public function projectMoneyHasBeenCollected(MoneyHasBeenCollected $event)
    {
        $this->jsonDatabase->update($event->accountId, function ($row) use ($event) {
            $row['balance'] -= $event->amount;

            return $row;
        });
    }

    public function projectAccountWasDeleted(AccountWasDeleted $event)
    {
        $this->jsonDatabase->delete($event->id);
    }
}
