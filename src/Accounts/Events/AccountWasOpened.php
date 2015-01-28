<?php namespace KBC\Accounts\Events;

use KBC\Accounts\Account;
use KBC\EventSourcing\Events\DomainEvent;

class AccountWasOpened implements DomainEvent {

    protected $account;

    function __construct(Account $account)
    {
        $this->account = $account;
    }

}