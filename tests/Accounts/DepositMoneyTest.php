<?php namespace Test\Accounts;

use Acme\Accounts\AccountRepository;
use Acme\Accounts\Commands\DepositMoney;
use Acme\Accounts\Commands\DepositMoneyHandler;
use Acme\Accounts\Events\AccountWasOpened;
use Acme\Accounts\Events\MoneyWasDeposited;
use Acme\Accounts\VO\AccountId;
use Acme\Accounts\VO\Amount;
use Acme\Accounts\VO\Name;
use Specification;

class DepositMoneyTest extends Specification
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

    /** @test */
    public function one_event_has_been_produced()
    {
        $this->assertCount(1, $this->producedEvents);
    }

    /** @test */
    public function a_MoneyWasDeposited_event_was_produced()
    {
        $this->assertInstanceOf(MoneyWasDeposited::class, $this->producedEvents[0]);
    }


    /** @test */
    public function the_account_has_been_deposited_with_50()
    {
        $this->assertEquals(50, $this->producedEvents[0]->getBalance()->getAmount());
    }

    /** @test */
    public function the_current_balance_should_be_50()
    {
        $this->assertEquals(50, $this->aggregate->balance->getAmount());
    }
}
