<?php namespace Acme\EventSourcing\Events;

trait EventGenerator
{
    protected $recordedEvents;

    public function releaseEvents()
    {
        $events = $this->recordedEvents;

        $this->recordedEvents = [];

        return $events;
    }

    public function apply(DomainEvent $event)
    {
        $this->recordedEvents[] = $event;
    }
}
