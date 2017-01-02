<?php namespace Acme\Baskets\Listeners;

use Acme\EventSourcing\Events\DomainEvent;
use Acme\EventSourcing\Events\Listener;

final class WhenBasketWasCreated implements Listener
{
    public function handle(DomainEvent $event)
    {
        var_dump("Created a basket");
    }
}
