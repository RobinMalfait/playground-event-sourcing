<?php namespace KBC\Accounts\Listeners;

use KBC\EventSourcing\Events\DomainEvent;
use KBC\EventSourcing\Events\Listener;

final class WhenAccountWasDeleted implements Listener {

    public function handle(DomainEvent $event)
    {
        var_dump("An account has been deleted.");
    }
}