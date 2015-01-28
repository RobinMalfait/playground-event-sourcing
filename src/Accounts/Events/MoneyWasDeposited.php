<?php namespace KBC\Accounts\Events;

use KBC\EventSourcing\Events\DomainEvent;

class MoneyWasDeposited implements DomainEvent {

    protected $accountId;

    protected $amount;

    function __construct($accountId, $amount)
    {
        $this->accountId = $accountId;
        $this->amount = $amount;
    }


}