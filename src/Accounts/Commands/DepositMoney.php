<?php namespace KBC\Accounts\Commands;

class DepositMoney
{
    public $id;

    public $amount;

    public function __construct($id, $amount)
    {
        $this->id = $id;
        $this->amount = $amount;
    }
}
