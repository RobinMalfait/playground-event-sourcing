<?php namespace KBC\Accounts;

use KBC\Accounts\Events\AccountWasClosed;
use KBC\Accounts\Events\AccountWasOpened;
use KBC\Accounts\Events\MoneyWasWithdrawn;
use KBC\Accounts\Events\MoneyWasDeposited;
use KBC\Core\BaseModel;

final class Account extends BaseModel
{
    public $name;

    public $balance;

    public $id;

    public $closed;

    public static function open($id, Name $name)
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
        $this->apply(new MoneyWasDeposited($this->id, $balance));
    }

    public function withdraw($balance)
    {
        $this->apply(new MoneyWasWithdrawn($this->id, $balance));
    }

    /* Respond to events */
    public function applyAccountWasOpened(AccountWasOpened $event)
    {
        $this->id = $event->getId();
        $this->balance = $event->getBalance();
        $this->name = $event->getName();
        $this->closed = false;
    }

    public function applyMoneyWasDeposited(MoneyWasDeposited $event)
    {
        if ($this->closed) {
            throw new AccountClosedException();
        }

        $this->balance = new Amount(
            $this->balance->getAmount() + $event->getBalance()->getAmount()
        );
    }

    public function applyMoneyWasWithdrawn(MoneyWasWithdrawn $event)
    {
        if ($this->closed) {
            throw new AccountClosedException();
        }

        $this->balance = new Amount(
            $this->balance->getAmount() - $event->getBalance()->getAmount()
        );
    }

    public function applyAccountWasClosed(AccountWasClosed $event)
    {
        $this->closed = true;
    }
}
