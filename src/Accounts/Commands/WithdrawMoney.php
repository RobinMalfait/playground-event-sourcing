<?php namespace KBC\Accounts\Commands;

use KBC\Accounts\VO\AccountId;
use KBC\Accounts\VO\Amount;

final class WithdrawMoney
{
    /** @var \KBC\Accounts\VO\AccountId */
    private $accountId;

    /** @var \KBC\Accounts\VO\Amount */
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
