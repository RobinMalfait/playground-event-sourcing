<?php namespace Test\Accounts;

use Acme\Accounts\AccountRepository;
use Acme\Accounts\Commands\OpenAccount;
use Acme\Accounts\Commands\OpenAccountHandler;
use Acme\Accounts\Events\AccountWasOpened;
use Acme\Accounts\VO\AccountId;
use Acme\Accounts\VO\Name;
use Specification;

class OpeningAnAccountTest extends Specification
{
    /**
     * Given events to build the aggregate
     *
     * @return array
     */
    public function given()
    {
        return [];
    }

    /**
     * Command to fire
     *
     * @return Command
     */
    public function when()
    {
        return new OpenAccount(AccountId::fromString("123"), new Name("John", "Doe"));
    }

    /**
     * The command handler
     *
     * @param $repository
     * @return mixed
     */
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
        $this->assertEquals(0, $this->aggregate->balance->getAmount());
    }

    /**
     * @test
     */
    public function the_full_name_should_be_john_doe()
    {
        $this->assertEquals("John Doe", $this->aggregate->name->getFullName());
    }
}
