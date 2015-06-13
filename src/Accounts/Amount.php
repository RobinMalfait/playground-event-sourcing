<?php namespace KBC\Accounts;

class Amount
{
    private $amount;

    public function __construct($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }
}
