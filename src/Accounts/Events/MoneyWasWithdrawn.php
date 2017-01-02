<?php namespace KBC\Accounts\Events;

use KBC\Accounts\VO\AccountId;
use KBC\Accounts\VO\Amount;
use KBC\EventSourcing\Events\DomainEvent;

final class MoneyWasWithdrawn implements DomainEvent
{

    /** @var \KBC\Accounts\VO\AccountId */
    private $accountId;

    /** @var \KBC\Accounts\VO\Amount */
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
