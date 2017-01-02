<?php namespace Acme\EventSourcing\Events;

interface Listener
{
    public function handle(DomainEvent $event);
}
