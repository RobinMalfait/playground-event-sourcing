<?php namespace Test\Accounts;

use KBC\Accounts\AccountRepository;
use KBC\Accounts\Commands\OpenAccount;
use KBC\Accounts\Commands\OpenAccountHandler;
use KBC\Accounts\Events\AccountWasOpened;
use KBC\Accounts\Name;
use Specification;

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
        return new OpenAccountHandler(new AccountRepository($repository));
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
    public function an_AccountWasOpened_event_was_produced()
    {
        $this->assertInstanceOf(AccountWasOpened::class, $this->producedEvents[0]);
    }

    /**
     * @test
     */
    public function the_balance_should_be_0()
    {
        $this->assertEquals(0, $this->aggregate->balance->amount);
    }

    /**
     * @test
     */
    public function the_name_should_be_john_doe()
    {
        $this->assertEquals("John Doe", $this->aggregate->name->getFullName());
    }
}
