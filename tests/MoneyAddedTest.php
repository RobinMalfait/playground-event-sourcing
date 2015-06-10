<?php

class MoneyAddedTest extends Specification
{
    protected $type = \KBC\Accounts\Account::class;

    public function given()
    {
        return [
            new \KBC\Accounts\Events\AccountWasOpened(123, new \KBC\Accounts\Name("Robin", "Malfait"), 0)
        ];
    }

    public function when()
    {
        return new \KBC\Accounts\Events\MoneyWasDeposited(123, 50);
    }

    /**
     * @test
     */
    public function one_event_has_been_produced()
    {
        $this->assertCount(1, $this->events);
    }

    /**
     * @test
     */
    public function the_account_has_been_deposited()
    {
        $this->assertEquals(50, $this->events[0]->amount);
    }

}
