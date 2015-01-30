<?php namespace KBC\Accounts\Events;

use KBC\EventSourcing\Events\DomainEvent;

final class AccountWasDeleted implements DomainEvent {

    public $id;

    function __construct($id)
    {
        $this->id = $id;
    }

}