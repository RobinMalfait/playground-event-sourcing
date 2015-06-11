<?php namespace KBC\EventSourcing;

use KBC\EventSourcing\Events\DomainEvent;
use ReflectionClass;

trait Replayer
{
    public static function replayEvents($events)
    {
        return array_reduce($events, function ($me, $event) {
            $me->applyAnEvent($event);

            return $me;
        }, new static);
    }

    public function applyAnEvent(DomainEvent $event)
    {
        $reflection = new ReflectionClass($event);
        $method = "apply" . $reflection->getShortName();

        return call_user_func([$this, $method], $event);
    }
}
