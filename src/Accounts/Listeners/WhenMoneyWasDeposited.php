<?php namespace KBC\Accounts\Listeners;

use KBC\EventSourcing\Events\DomainEvent;
use KBC\EventSourcing\Events\Listener;

final class WhenMoneyWasDeposited implements Listener
{
    public function handle(DomainEvent $event)
    {
        var_dump("€{$event->balance->amount} has been deposited.");
    }
}
