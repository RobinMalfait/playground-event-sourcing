<?php namespace Acme\Accounts\Listeners;

use Acme\EventSourcing\Events\DomainEvent;
use Acme\EventSourcing\Events\Listener;

final class WhenAccountWasOpened implements Listener
{
    public function handle(DomainEvent $event)
    {
        var_dump("An account has been opened for {$event->getName()->getFullName()} with a balance of {$event->getBalance()->getAmount()} EUR.");
    }
}
