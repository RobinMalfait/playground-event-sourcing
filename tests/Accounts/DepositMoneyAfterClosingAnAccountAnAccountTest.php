<?php namespace Test\Accounts;

use KBC\Accounts\Account;
use KBC\Accounts\AccountClosedException;
use KBC\Accounts\AccountRepository;
use KBC\Accounts\Amount;
use KBC\Accounts\Commands\DepositMoney;
use KBC\Accounts\Commands\DepositMoneyHandler;
use KBC\Accounts\Events\AccountWasClosed;
use KBC\Accounts\Events\AccountWasOpened;
use KBC\Accounts\Name;
use Specification;

class DepositMoneyAfterClosingAnAccountAnAccountTest extends Specification
{
    public function given()
    {
        return [
            new AccountWasOpened(123, new Name("John", "Doe"), new Amount(0)),
            new AccountWasClosed(123)
        ];
    }

    public function when()
    {
        return new DepositMoney(123, new Amount(50));
    }

    public function handler($repository)
    {
        return new DepositMoneyHandler(new AccountRepository($repository));
    }

    /**
     * @test
     */
    public function none_events_have_been_produced()
    {
        $this->assertCount(0, $this->producedEvents);
    }

    /**
     * @test
     */
    public function an_AccountClosedException_was_thrown()
    {
        $this->throws(new AccountClosedException());
    }
}
