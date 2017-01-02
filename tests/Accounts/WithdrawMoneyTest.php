<?php namespace Test\Accounts;

use Acme\Accounts\AccountRepository;
use Acme\Accounts\Commands\WithdrawMoney;
use Acme\Accounts\Commands\WithdrawMoneyHandler;
use Acme\Accounts\Events\AccountWasOpened;
use Acme\Accounts\Events\MoneyWasWithdrawn;
use Acme\Accounts\Events\MoneyWasDeposited;
use Acme\Accounts\VO\AccountId;
use Acme\Accounts\VO\Amount;
use Acme\Accounts\VO\Name;
use Specification;

class WithdrawMoneyTest extends Specification
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
            new MoneyWasDeposited($accountId, new Amount(100)),
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
    public function a_MoneyWasWithdrawn_event_was_produced()
    {
        $this->assertInstanceOf(MoneyWasWithdrawn::class, $this->producedEvents[0]);
    }

    /**
     * @test
     */
    public function the_new_saldo_is_25()
    {
        $this->assertEquals(25, $this->aggregate->balance->getAmount());
    }
}
