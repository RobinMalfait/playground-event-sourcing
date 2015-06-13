<?php namespace KBC\Accounts\Events;

use KBC\EventSourcing\Events\DomainEvent;

final class AccountWasClosed implements DomainEvent
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
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
}
