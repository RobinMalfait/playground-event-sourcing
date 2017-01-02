<?php namespace KBC\Accounts;

use KBC\Accounts\Events\AccountWasClosed;
use KBC\Accounts\Events\AccountWasOpened;
use KBC\Accounts\Events\MoneyWasWithdrawn;
use KBC\Accounts\Events\MoneyWasDeposited;
use KBC\Accounts\VO\AccountId;
use KBC\Accounts\VO\Amount;
use KBC\Accounts\VO\Name;
use KBC\Core\AggregateRoot;

final class Account extends AggregateRoot
{

    /** @var \KBC\Accounts\VO\Name */
    public $name;

    /** @var \KBC\Accounts\VO\Amount */
    public $balance;

    /** @var \KBC\Accounts\VO\AccountId */
    public $id;

    /** @var bool */
    public $closed;

    public static function open(AccountId $id, Name $name)
    {
        $me = new static();

        $me->apply(new AccountWasOpened($id, $name, new Amount(0)));

        return $me;
    }

    public function close()
    {
        $this->apply(new AccountWasClosed($this->id));
    }

    public function deposit($balance)
    {
        if ($this->closed) {
            throw new AccountClosedException();
        }

        $this->apply(new MoneyWasDeposited($this->id, $balance));
    }

    public function withdraw($balance)
    {
        if ($this->closed) {
            throw new AccountClosedException();
        }

        $this->apply(new MoneyWasWithdrawn($this->id, $balance));
    }

    /* Respond to events */
    public function applyAccountWasOpened(AccountWasOpened $event)
    {
        $this->id = $event->getAccountId();
        $this->balance = $event->getBalance();
        $this->name = $event->getName();
        $this->closed = false;
    }

    public function applyMoneyWasDeposited(MoneyWasDeposited $event)
    {
        $this->balance = new Amount(
            $this->balance->getAmount() + $event->getBalance()->getAmount()
        );
    }

    public function applyMoneyWasWithdrawn(MoneyWasWithdrawn $event)
    {
        $this->balance = new Amount(
            $this->balance->getAmount() - $event->getBalance()->getAmount()
        );
    }

    public function applyAccountWasClosed(AccountWasClosed $event)
    {
        $this->closed = true;
    }
}
