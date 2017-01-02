<?php namespace Acme\Accounts;

use Acme\Accounts\Events\AccountWasClosed;
use Acme\Accounts\Events\AccountWasOpened;
use Acme\Accounts\Events\MoneyWasWithdrawn;
use Acme\Accounts\Events\MoneyWasDeposited;
use Acme\Storages\JsonDatabase;

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
            'id' => $event->getAccountId()->getId(),
            'name' => $event->getName()->getFullName(),
            'balance' => $event->getBalance()->getAmount(),
            'closed' => $event->isClosed()
        ]);
    }

    public function projectMoneyWasDeposited(MoneyWasDeposited $event)
    {
        $this->jsonDatabase->update($event, function ($row) use ($event) {
            $row['balance'] += $event->getBalance()->getAmount();

            return $row;
        });
    }

    public function projectMoneyWasWithdrawn(MoneyWasWithdrawn $event)
    {
        $this->jsonDatabase->update($event, function ($row) use ($event) {
            $row['balance'] -= $event->getBalance()->getAmount();

            return $row;
        });
    }

    public function projectAccountWasClosed(AccountWasClosed $event)
    {
        $this->jsonDatabase->update($event, function ($row) {
            $row['closed'] = true;

            return $row;
        });
    }
}
