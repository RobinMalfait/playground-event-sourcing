<?php namespace Test\Accounts;

use KBC\Accounts\AccountClosedException;
use KBC\Accounts\AccountRepository;
use KBC\Accounts\Commands\DepositMoney;
use KBC\Accounts\Commands\DepositMoneyHandler;
use KBC\Accounts\Events\AccountWasClosed;
use KBC\Accounts\Events\AccountWasOpened;
use KBC\Accounts\VO\Amount;
use KBC\Accounts\VO\Name;
use Specification;

class DepositMoneyAfterClosingAnAccountTest extends Specification
{
    /**
     * Given events to build the aggregate
     *
     * @return array
     */
    public function given()
    {
        return [
            new AccountWasOpened(123, new Name("John", "Doe"), new Amount(0)),
            new AccountWasClosed(123)
        ];
    }

    /**
     * Command to fire
     *
     * @return Command
     */
    public function when()
    {
        return new DepositMoney(123, new Amount(50));
    }

    /**
     * The command handler
     *
     * @param $repository
     * @return mixed
     */
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
