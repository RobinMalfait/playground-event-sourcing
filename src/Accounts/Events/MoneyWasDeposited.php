<?php namespace KBC\Accounts\Events;

use KBC\Accounts\Amount;
use KBC\EventSourcing\Events\DomainEvent;

final class MoneyWasDeposited implements DomainEvent
{
    public $accountId;

    public $balance;

    public function __construct($accountId, Amount $balance)
    {
        $this->accountId = $accountId;
        $this->balance = $balance;
    }
}
