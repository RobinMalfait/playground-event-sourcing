<?php namespace Acme\Accounts\Commands;

use Acme\Accounts\VO\AccountId;
use Acme\Accounts\VO\Amount;

final class DepositMoney
{

    /** @var \Acme\Accounts\VO\AccountId */
    private $accountId;

    /** @var \Acme\Accounts\VO\Amount */
    private $balance;

    public function __construct(AccountId $accountId, Amount $balance)
    {
        $this->accountId = $accountId;
        $this->balance = $balance;
    }

    public function getAccountId()
    {
        return $this->accountId;
    }

    public function getBalance()
    {
        return $this->balance;
    }
}
