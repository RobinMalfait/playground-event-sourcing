<?php namespace Acme\Accounts\VO;

final class Amount
{
    /** @var double */
    private $amount;

    public function __construct($amount)
    {
        $this->amount = $amount;
    }

    public function getAmount()
    {
        return $this->amount;
    }
}
