<?php namespace KBC\EventSourcing\Events;

interface DomainEvent
{
    public function getAggregateId();
}
