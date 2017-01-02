<?php namespace Acme\Accounts\Events;

use Acme\Accounts\VO\AccountId;
use Acme\Accounts\VO\Amount;
use Acme\EventSourcing\Events\DomainEvent;

final class MoneyWasDeposited implements DomainEvent
{

    /** @var \Acme\Accounts\VO\AccountId */
    private $accountId;

    /** @var \Acme\Accounts\VO\Amount */
    private $balance;

    public function __construct(AccountId $accountId, Amount $balance)
    {
        $this->accountId = $accountId;
        $this->balance = $balance;
    }

    public function getAggregateId()
    {
        return $this->accountId->getId();
    }

    public function getAccountId()
    {
        return $this->accountId;
    }

    public function getBalance()
    {
        return $this->balance;
    }
}
