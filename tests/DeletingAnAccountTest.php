<?php

use KBC\Accounts\Commands\DeleteAccount;
use KBC\Accounts\Commands\DeleteAccountHandler;
use KBC\Accounts\Events\AccountWasDeleted;
use KBC\Accounts\Events\AccountWasOpened;
use KBC\Accounts\Name;

class DeletingAnAccountTest extends Specification
{
    public function given()
    {
        return [
            new AccountWasOpened(123, new Name("John", "Doe"), 0)
        ];
    }

    public function when()
    {
        return new DeleteAccount(123);
    }

    public function handler($repository)
    {
        return new DeleteAccountHandler($repository);
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
    public function an_account_was_deleted_event_was_produced()
    {
        $this->assertInstanceOf(AccountWasDeleted::class, $this->producedEvents[0]);
    }


    /**
     * @test
     */
    public function the_account_is_deleted()
    {
        $this->assertNull($this->state);
    }
}
