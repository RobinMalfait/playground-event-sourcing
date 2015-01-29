<?php namespace KBC\Accounts;

use KBC\Accounts\Events\AccountWasOpened;
use KBC\Accounts\Events\MoneyHasBeenCollected;
use KBC\Accounts\Events\MoneyWasDeposited;
use KBC\Core\BaseModel;

final class Account extends BaseModel {

    public $name;

    public $id;

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

        $this->balance += $amount; // Now we are here.
    }

    public function withdraw($amount)
    {
        $this->recordThat(new MoneyHasBeenCollected($this->id, $amount));

        $this->balance -= $amount;
    }

    /* Respond to events */
    public function applyAccountWasOpened(AccountWasOpened $event)
    {
        $this->balance = $event->balance;
        $this->name = $event->name;
        $this->id = $event->id;
    }

    public function applyMoneyWasDeposited(MoneyWasDeposited $event)
    {
        $this->balance += $event->amount;
    }

    public function applyMoneyHasBeenCollected(MoneyHasBeenCollected $event)
    {
        $this->balance -= $event->amount;
    }
}