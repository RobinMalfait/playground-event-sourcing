<?php namespace Test\Accounts;

use KBC\Accounts\AccountRepository;
use KBC\Accounts\Commands\WithdrawMoney;
use KBC\Accounts\Commands\WithdrawMoneyHandler;
use KBC\Accounts\Events\AccountWasOpened;
use KBC\Accounts\Events\MoneyWasWithdrawn;
use KBC\Accounts\Events\MoneyWasDeposited;
use KBC\Accounts\VO\Amount;
use KBC\Accounts\VO\Name;
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
        return [
            new AccountWasOpened(123, new Name("John", "Doe"), new Amount(0)),
            new MoneyWasDeposited(123, new Amount(100)),
        ];
    }

    /**
     * Command to fire
     *
     * @return Command
     */
    public function when()
    {
        return new WithdrawMoney(123, new Amount(75));
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
