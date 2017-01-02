<?php namespace Acme\Accounts\Commands;

use Acme\Accounts\VO\AccountId;

final class CloseAccount
{

    /** @var \Acme\Accounts\VO\AccountId */
    private $accountId;

    private function __construct(AccountId $accountId)
    {
        $this->accountId = $accountId;
    }

    public static function of(AccountId $accountId)
    {
        return new self($accountId);
    }

    public function getAccountId()
    {
        return $this->accountId;
    }
}
