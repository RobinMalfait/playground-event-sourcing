<?php namespace Acme\Accounts\Events;

use Acme\Accounts\VO\AccountId;
use Acme\EventSourcing\Events\DomainEvent;

final class AccountWasClosed implements DomainEvent
{
    /** @var \Acme\Accounts\VO\AccountId */
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
