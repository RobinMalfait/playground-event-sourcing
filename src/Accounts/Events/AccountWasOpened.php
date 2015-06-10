<?php namespace KBC\Accounts\Events;

use KBC\Accounts\Name;
use KBC\EventSourcing\Events\DomainEvent;

final class AccountWasOpened implements DomainEvent
{
    public $id;

    public $name;

    public $balance;

    public function __construct($id, Name $name, $balance)
    {
        $this->id = $id;
        $this->name = $name;
        $this->balance = $balance;
    }
}
