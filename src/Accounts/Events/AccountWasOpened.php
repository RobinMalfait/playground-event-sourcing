<?php namespace Acme\Accounts\Events;

use Acme\Accounts\VO\AccountId;
use Acme\Accounts\VO\Amount;
use Acme\Accounts\VO\Name;
use Acme\EventSourcing\Events\DomainEvent;

final class AccountWasOpened implements DomainEvent
{

    /** @var \Acme\Accounts\VO\AccountId */
    private $accountId;

    /** @var \Acme\Accounts\VO\Name */
    private $name;

    /** @var \Acme\Accounts\VO\Amount */
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
