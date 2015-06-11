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
        $this->id = $event->id;
        $this->balance = $event->balance;
        $this->name = $event->name;
        $this->closed = false;
    }

    public function applyMoneyWasDeposited(MoneyWasDeposited $event)
    {
        if ($this->closed) {
            throw new AccountClosedException();
        }

        $this->balance->amount += $event->balance->amount;
    }

    public function applyMoneyWasWithdrawn(MoneyWasWithdrawn $event)
    {
        if ($this->closed) {
            throw new AccountClosedException();
        }

        $this->balance->amount -= $event->balance->amount;
    }

    public function applyAccountWasClosed(AccountWasClosed $event)
    {
        $this->closed = true;
    }
}
