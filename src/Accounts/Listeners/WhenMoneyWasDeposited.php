<?php namespace Acme\Accounts\Listeners;

use Acme\EventSourcing\Events\DomainEvent;
use Acme\EventSourcing\Events\Listener;

final class WhenMoneyWasDeposited implements Listener
{
    public function handle(DomainEvent $event)
    {
        var_dump("€{$event->getBalance()->getAmount()} has been deposited.");
    }
}
