<?php namespace KBC\Accounts\Events;

use KBC\Accounts\Amount;
use KBC\EventSourcing\Events\DomainEvent;

final class MoneyWasWithdrawn implements DomainEvent
{
    public $accountId;

    public $balance;

    public function __construct($accountId, Amount $balance)
    {
        $this->accountId = $accountId;
        $this->balance = $balance;
    }

    public function getAggregateId()
    {
        return $this->accountId;
    }
}
