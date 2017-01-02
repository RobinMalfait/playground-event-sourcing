<?php namespace Test\Accounts;

use Acme\Accounts\AccountClosedException;
use Acme\Accounts\AccountRepository;
use Acme\Accounts\Commands\DepositMoney;
use Acme\Accounts\Commands\DepositMoneyHandler;
use Acme\Accounts\Events\AccountWasClosed;
use Acme\Accounts\Events\AccountWasOpened;
use Acme\Accounts\VO\AccountId;
use Acme\Accounts\VO\Amount;
use Acme\Accounts\VO\Name;
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
        $accountId = AccountId::fromString("123");

        return [
            new AccountWasOpened($accountId, new Name("John", "Doe"), new Amount(0)),
            new AccountWasClosed($accountId)
        ];
    }

    /**
     * Command to fire
     *
     * @return Command
     */
    public function when()
    {
        return new DepositMoney(AccountId::fromString("123"), new Amount(50));
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
