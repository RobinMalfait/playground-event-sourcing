<?php namespace KBC\Accounts\Commands;

use KBC\Accounts\VO\AccountId;
use KBC\Accounts\VO\Name;

final class OpenAccount
{

    /** @var \KBC\Accounts\VO\AccountId */
    private $accountId;

    /** @var \KBC\Accounts\VO\Name */
    private $name;

    public function __construct(AccountId $accountId, Name $name)
    {
        $this->accountId = $accountId;
        $this->name = $name;
    }

    public function getAccountId()
    {
        return $this->accountId;
    }

    public function getName()
    {
        return $this->name;
    }
}
