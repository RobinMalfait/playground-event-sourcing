<?php namespace KBC\Accounts\Commands;

use KBC\Accounts\VO\AccountId;

final class CloseAccount
{

    /** @var \KBC\Accounts\VO\AccountId */
    private $accountId;

    public function __construct(AccountId $accountId)
    {
        $this->accountId = $accountId;
    }

    public function getAccountId()
    {
        return $this->accountId;
    }
}
