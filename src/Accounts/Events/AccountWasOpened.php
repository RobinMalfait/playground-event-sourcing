<?php namespace KBC\Accounts\Events;

use KBC\Accounts\Amount;
use KBC\Accounts\Name;
use KBC\EventSourcing\Events\DomainEvent;

final class AccountWasOpened implements DomainEvent
{
    public $id;

    public $name;

    public $balance;

    public $closed;

    public function __construct($id, Name $name, Amount $balance)
    {
        $this->id = $id;
        $this->name = $name;
        $this->balance = $balance;
        $this->closed = false;
    }

    public function getAggregateId()
    {
        return $this->id;
    }
}
