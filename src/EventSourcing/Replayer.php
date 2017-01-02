<?php namespace Acme\EventSourcing;

use Acme\EventSourcing\Events\DomainEvent;
use ReflectionClass;

trait Replayer
{
    public static function replayEvents($events)
    {
        return array_reduce($events, function ($me, $event) {
            return $me->applyAnEvent($event);
        }, new static);
    }

    public function applyAnEvent(DomainEvent $event)
    {
        $reflection = new ReflectionClass($event);
        $method = "apply" . $reflection->getShortName();

        call_user_func([$this, $method], $event);

        $this->version++;

        return $this;
    }
}
