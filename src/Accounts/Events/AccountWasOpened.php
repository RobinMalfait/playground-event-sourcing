<?php namespace KBC\Accounts\Events;

use KBC\Accounts\VO\Amount;
use KBC\Accounts\VO\Name;
use KBC\EventSourcing\Events\DomainEvent;

final class AccountWasOpened implements DomainEvent
{
    private $id;

    private $name;

    private $balance;

    private $closed;

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

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Amount
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @return boolean
     */
    public function isClosed()
    {
        return $this->closed;
    }
}
