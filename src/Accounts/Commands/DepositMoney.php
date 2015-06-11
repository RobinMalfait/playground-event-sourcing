<?php namespace KBC\Accounts\Commands;

use KBC\Accounts\Amount;

class DepositMoney
{
    public $id;

    public $balance;

    public function __construct($id, Amount $balance)
    {
        $this->id = $id;
        $this->balance = $balance;
    }
}
