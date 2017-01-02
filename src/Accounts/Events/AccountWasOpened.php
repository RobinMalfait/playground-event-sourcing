<?php namespace KBC\Accounts\Events;

use KBC\Accounts\VO\AccountId;
use KBC\Accounts\VO\Amount;
use KBC\Accounts\VO\Name;
use KBC\EventSourcing\Events\DomainEvent;

final class AccountWasOpened implements DomainEvent
{

    /** @var \KBC\Accounts\VO\AccountId */
    private $accountId;

    /** @var \KBC\Accounts\VO\Name */
    private $name;

    /** @var \KBC\Accounts\VO\Amount */
    private $balance;

    /** @var bool */
    private $closed;

    public function __construct(AccountId $accountId, Name $name, Amount $balance)
    {
        $this->accountId = $accountId;
        $this->name = $name;
        $this->balance = $balance;
        $this->closed = false;
    }

    public function getAggregateId()
    {
        return $this->accountId->getId();
    }

    public function getAccountId()
    {
        return $this->accountId;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getBalance()
    {
        return $this->balance;
    }

    public function isClosed()
    {
        return $this->closed;
    }
}
