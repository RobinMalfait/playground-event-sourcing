<?php namespace KBC\Baskets\Listeners;

use KBC\EventSourcing\Events\DomainEvent;
use KBC\EventSourcing\Events\Listener;

final class WhenBasketWasCreated implements Listener
{
    public function handle(DomainEvent $event)
    {
        var_dump("Created a basket");
    }
}
