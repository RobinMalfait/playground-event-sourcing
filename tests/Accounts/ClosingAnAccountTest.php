<?php namespace Test\Accounts;

use Command;
use Acme\Accounts\AccountRepository;
use Acme\Accounts\Commands\CloseAccount;
use Acme\Accounts\Commands\CloseAccountHandler;
use Acme\Accounts\Events\AccountWasClosed;
use Acme\Accounts\Events\AccountWasOpened;
use Acme\Accounts\VO\AccountId;
use Acme\Accounts\VO\Amount;
use Acme\Accounts\VO\Name;
use Specification;

class ClosingAnAccountTest extends Specification
{
    /**
     * Given events to build the aggregate
     *
     * @return array
     */
    public function given()
    {
        return [
            new AccountWasOpened(
                AccountId::fromString("123"),
                new Name("John", "Doe"),
                new Amount(0)
            )
        ];
    }

    /**
     * Command to fire
     *
     * @return Command
     */
    public function when()
    {
        return new CloseAccount(
            AccountId::fromString("123")
        );
    }

    /**
     * The command handler
     *
     * @param $repository
     * @return mixed
     */
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
    public function an_AccountWasClosed_event_was_produced()
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
