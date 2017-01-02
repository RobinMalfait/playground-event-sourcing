<?php namespace Acme\Accounts\Commands;

use Acme\Accounts\VO\AccountId;

final class CloseAccount
{

    /** @var \Acme\Accounts\VO\AccountId */
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
