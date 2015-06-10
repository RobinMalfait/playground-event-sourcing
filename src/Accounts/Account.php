<?php namespace KBC\Accounts;

use KBC\Accounts\Events\AccountWasDeleted;
use KBC\Accounts\Events\AccountWasOpened;
use KBC\Accounts\Events\MoneyHasBeenCollected;
use KBC\Accounts\Events\MoneyWasDeposited;
use KBC\Core\BaseModel;

final class Account extends BaseModel
{
    public $name;

    public $balance;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public static function open($id, Name $name)
    {
        $account = new static($id);
        $account->apply(new AccountWasOpened($id, $name, 0));
        return $account;
    }

    /**
     *
     */
    public function delete()
    {
        $this->apply(new AccountWasDeleted($this->id));
    }

    public function deposit($amount)
    {
        $this->apply(new MoneyWasDeposited($this->id, $amount));
    }

    public function withdraw($amount)
    {
        $this->apply(new MoneyHasBeenCollected($this->id, $amount));
    }

    /* Respond to events */
    public static function applyAccountWasOpened($state, AccountWasOpened $event)
    {
        $state = new self($event->id);
        $state->balance = $event->balance;
        $state->name = $event->name;

        return $state;
    }

    public static function applyMoneyWasDeposited($state, MoneyWasDeposited $event)
    {
        $state->balance += $event->amount;

        return $state;
    }

    public static function applyMoneyHasBeenCollected($state, MoneyHasBeenCollected $event)
    {
        $state->balance -= $event->amount;

        return $state;
    }

    public static function applyAccountWasDeleted($state, AccountWasDeleted $event)
    {
        // This is basically deleting.
        return null;
    }
}
