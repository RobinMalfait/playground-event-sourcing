<?php namespace KBC\Accounts\Events;

use KBC\Accounts\VO\AccountId;
use KBC\EventSourcing\Events\DomainEvent;

final class AccountWasClosed implements DomainEvent
{
    /** @var \KBC\Accounts\VO\AccountId */
    private $accountId;

    public function __construct(AccountId $accountId)
    {
        $this->accountId = $accountId;
    }

    public function getAggregateId()
    {
        return $this->accountId->getId();
    }

    public function getAccountId()
    {
        return $this->accountId;
    }
}
