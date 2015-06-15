<?php namespace KBC\Accounts\Events;

use KBC\EventSourcing\Events\DomainEvent;

final class AccountWasClosed implements DomainEvent
{
    private $accountId;

    public function __construct($accountId)
    {
        $this->accountId = $accountId;
    }

    public function getAggregateId()
    {
        return $this->accountId;
    }

    /**
     * @return mixed
     */
    public function getAccountId()
    {
        return $this->accountId;
    }
}
