<?php namespace KBC\Accounts\Events;

use KBC\Accounts\VO\Amount;
use KBC\EventSourcing\Events\DomainEvent;

final class MoneyWasWithdrawn implements DomainEvent
{
    private $accountId;

    private $balance;

    public function __construct($accountId, Amount $balance)
    {
        $this->accountId = $accountId;
        $this->balance = $balance;
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

    /**
     * @return Amount
     */
    public function getBalance()
    {
        return $this->balance;
    }
}
