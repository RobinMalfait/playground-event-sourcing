<?php namespace KBC\Accounts\Commands;

use KBC\Accounts\VO\Amount;

final class DepositMoney
{
    private $id;

    private $balance;

    public function __construct($id, Amount $balance)
    {
        $this->id = $id;
        $this->balance = $balance;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Amount
     */
    public function getBalance()
    {
        return $this->balance;
    }
}
