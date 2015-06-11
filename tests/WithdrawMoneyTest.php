<?php

use KBC\Accounts\AccountRepository;
use KBC\Accounts\Commands\WithdrawMoney;
use KBC\Accounts\Commands\WithdrawMoneyHandler;
use KBC\Accounts\Events\AccountWasOpened;
use KBC\Accounts\Events\MoneyWasWithdrawn;
use KBC\Accounts\Events\MoneyWasDeposited;
use KBC\Accounts\Name;

class WithdrawMoneyTest extends Specification
{
    public function given()
    {
        return [
            new AccountWasOpened(123, new Name("John", "Doe"), 0),
            new MoneyWasDeposited(123, 100),
        ];
    }

    public function when()
    {
        return new WithdrawMoney(123, 75);
    }

    public function handler($repository)
    {
        return new WithdrawMoneyHandler(new AccountRepository($repository));
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
    public function an_money_was_withdrawn_event_was_produced()
    {
        $this->assertInstanceOf(MoneyWasWithdrawn::class, $this->producedEvents[0]);
    }

    /**
     * @test
     */
    public function the_new_saldo_is_25()
    {
        $this->assertEquals(25, $this->aggregate->balance);
    }
}
