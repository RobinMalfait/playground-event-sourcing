<?php namespace KBC\Accounts\Events;

use KBC\EventSourcing\Events\DomainEvent;

final class AccountWasClosed implements DomainEvent
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
}
