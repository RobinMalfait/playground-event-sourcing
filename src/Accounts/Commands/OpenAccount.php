<?php namespace Acme\Accounts\Commands;

use Acme\Accounts\VO\AccountId;
use Acme\Accounts\VO\Name;

final class OpenAccount
{

    /** @var \Acme\Accounts\VO\AccountId */
    private $accountId;

    /** @var \Acme\Accounts\VO\Name */
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
