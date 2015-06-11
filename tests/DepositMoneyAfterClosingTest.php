<?php

use KBC\Accounts\AccountClosedException;
use KBC\Accounts\AccountRepository;
use KBC\Accounts\Commands\DepositMoney;
use KBC\Accounts\Commands\DepositMoneyHandler;
use KBC\Accounts\Events\AccountWasClosed;
use KBC\Accounts\Events\AccountWasOpened;
use KBC\Accounts\Events\MoneyWasDeposited;
use KBC\Accounts\Name;

class DepositMoneyAfterClosingTest extends Specification
{
    public function given()
    {
        return [
            new AccountWasOpened(123, new Name("John", "Doe"), 0),
            new AccountWasClosed(123)
        ];
    }

    public function when()
    {
        return new DepositMoney(123, 50);
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
    public function an_exception_was_thrown()
    {
        $this->assertInstanceOf(AccountClosedException::class, $this->caughtException);
    }
}
