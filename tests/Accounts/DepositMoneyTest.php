<?php namespace Test\Accounts;

use KBC\Accounts\AccountRepository;
use KBC\Accounts\Amount;
use KBC\Accounts\Commands\DepositMoney;
use KBC\Accounts\Commands\DepositMoneyHandler;
use KBC\Accounts\Events\AccountWasOpened;
use KBC\Accounts\Events\MoneyWasDeposited;
use KBC\Accounts\Name;
use Specification;

class DepositMoneyTest extends Specification
{
    public function given()
    {
        return [
            new AccountWasOpened(123, new Name("John", "Doe"), new Amount(0))
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
    public function one_event_has_been_produced()
    {
        $this->assertCount(1, $this->producedEvents);
    }

    /**
     * @test
     */
    public function an_MoneyWasDeposited_event_was_produced()
    {
        $this->assertInstanceOf(MoneyWasDeposited::class, $this->producedEvents[0]);
    }


    /**
     * @test
     */
    public function the_account_has_been_deposited()
    {
        $this->assertEquals(50, $this->producedEvents[0]->balance->amount);
    }

    /**
     * @test
     */
    public function the_current_balance_should_be_50()
    {
        $this->assertEquals(50, $this->aggregate->balance->amount);
    }
}
