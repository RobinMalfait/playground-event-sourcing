<?php

use KBC\Accounts\Commands\OpenAccount;
use KBC\Accounts\Commands\OpenAccountHandler;
use KBC\Accounts\Events\AccountWasOpened;
use KBC\Accounts\Name;

class OpeningAnAccountTest extends Specification
{
    public function given()
    {
        return [];
    }

    public function when()
    {
        return new OpenAccount(123, new Name("John", "Doe"));
    }

    public function handler($repository)
    {
        return new OpenAccountHandler($repository);
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
    public function an_account_was_opened_event_was_produced()
    {
        $this->assertInstanceOf(AccountWasOpened::class, $this->producedEvents[0]);
    }

    /**
     * @test
     */
    public function the_balance_should_be_0()
    {
        $this->assertEquals(0, $this->state->balance);
    }

    /**
     * @test
     */
    public function the_name_should_be_john_doe()
    {
        $this->assertEquals("John Doe", $this->state->name->getFullName());
    }
}
