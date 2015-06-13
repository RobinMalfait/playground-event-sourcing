<?php namespace KBC\Accounts\VO;

final class Amount
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
