<?php

use KBC\Accounts\AccountRepository;
use KBC\Accounts\Commands\CloseAccount;
use KBC\Accounts\Commands\CloseAccountHandler;
use KBC\Accounts\Events\AccountWasClosed;
use KBC\Accounts\Events\AccountWasOpened;
use KBC\Accounts\Name;

class ClosingAnAccountTest extends Specification
{
    public function given()
    {
        return [
            new AccountWasOpened(123, new Name("John", "Doe"), 0)
        ];
    }

    public function when()
    {
        return new CloseAccount(123);
    }

    public function handler($repository)
    {
        return new CloseAccountHandler(new AccountRepository($repository));
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
    public function an_account_was_closed_event_was_produced()
    {
        $this->assertInstanceOf(AccountWasClosed::class, $this->producedEvents[0]);
    }

    /**
     * @test
     */
    public function the_account_is_closed()
    {
        $this->assertTrue($this->aggregate->closed);
    }
}
