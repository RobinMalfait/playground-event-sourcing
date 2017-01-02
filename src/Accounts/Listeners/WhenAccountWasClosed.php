<?php namespace Acme\Accounts\Listeners;

use Acme\EventSourcing\Events\DomainEvent;
use Acme\EventSourcing\Events\Listener;

final class WhenAccountWasClosed implements Listener
{
    public function handle(DomainEvent $event)
    {
        var_dump("An account has been closed.");
    }
}
