<?php namespace KBC\EventSourcing\Events;

interface Listener
{
    public function handle(DomainEvent $event);
}
