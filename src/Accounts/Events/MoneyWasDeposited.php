<?php namespace KBC\Accounts\Events;

use KBC\EventSourcing\Events\DomainEvent;

final class MoneyWasDeposited implements DomainEvent {

    public $accountId;

    public $amount;

    function __construct($accountId, $amount)
    {
        $this->accountId = $accountId;
        $this->amount = $amount;
    }


}