<?php namespace Acme\EventSourcing\Events;

interface DomainEvent
{
    public function getAggregateId();
}
