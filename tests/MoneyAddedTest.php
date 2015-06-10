<?php

use KBC\Accounts\Commands\DepositMoney;
use KBC\Accounts\Commands\DepositMoneyHandler;
use KBC\Accounts\Events\AccountWasOpened;
use KBC\Accounts\Name;

class MoneyAddedTest extends Specification
{
    public function given()
    {
        return [
            new AccountWasOpened(123, new Name("John", "Doe"), 0)
        ];
    }

    public function when()
    {
        return new DepositMoney(123, 50);
    }

    public function handler($repository)
    {
        return new DepositMoneyHandler($repository);
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
    public function the_account_has_been_deposited()
    {
        $this->assertEquals(50, $this->producedEvents[0]->amount);
    }
}
