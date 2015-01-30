<?php namespace KBC\Accounts;

use KBC\Accounts\Events\AccountWasOpened;
use KBC\Accounts\Events\MoneyHasBeenCollected;
use KBC\Accounts\Events\MoneyWasDeposited;
use KBC\Core\BaseModel;

final class Account extends BaseModel {

    public $name;

    public $balance;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public static function open($id, Name $name)
    {
        $account = new Static($id);
        $account->balance = 0;
        $account->name = $name;

        $account->recordThat(new AccountWasOpened($account->id, $account->name, $account->balance));

        return $account;
    }

    public function deposit($amount)
    {
        $this->recordThat(new MoneyWasDeposited($this->id, $amount));

        $this->balance += $amount;
    }

    public function withdraw($amount)
    {
        $this->recordThat(new MoneyHasBeenCollected($this->id, $amount));

        $this->balance -= $amount;
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

}