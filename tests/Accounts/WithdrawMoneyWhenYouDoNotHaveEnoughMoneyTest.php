<?php namespace Test\Accounts;

use Acme\Accounts\AccountDoesNotHaveEnoughMoneyException;
use Acme\Accounts\AccountRepository;
use Acme\Accounts\Commands\WithdrawMoney;
use Acme\Accounts\Commands\WithdrawMoneyHandler;
use Acme\Accounts\Events\AccountWasOpened;
use Acme\Accounts\VO\AccountId;
use Acme\Accounts\VO\Amount;
use Acme\Accounts\VO\Name;
use Specification;

class WithdrawMoneyWhenYouDoNotHaveEnoughMoneyTest extends Specification
{
    /**
     * Given events to build the aggregate
     *
     * @return array
     */
    public function given()
    {
        return [
            new AccountWasOpened(AccountId::fromString("123"), new Name("John", "Doe"), new Amount(0))
        ];
    }

    /**
     * Command to fire
     *
     * @return Command
     */
    public function when()
    {
        return new WithdrawMoney(AccountId::fromString("123"), new Amount(75));
    }

    /**
     * The command handler
     *
     * @param $repository
     * @return mixed
     */
    public function handler($repository)
    {
        return new WithdrawMoneyHandler(new AccountRepository($repository));
    }

    /** @test */
    public function none_events_have_been_produced()
    {
        $this->assertCount(0, $this->producedEvents);
    }

    /** @test */
    public function an_AccountDoesNotHaveEnoughMoneyException_was_thrown()
    {
        $this->throws(new AccountDoesNotHaveEnoughMoneyException());
    }
}
