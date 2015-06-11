<?php namespace KBC\EventSourcing;

use KBC\EventSourcing\Events\DomainEvent;
use ReflectionClass;

trait Replayer
{
    public static function replayEvents($events)
    {
        return array_reduce($events, function ($state, $event) {
            return self::applyAnEvent($state, $event);
        }, null);
    }

    public static function applyAnEvent($state, DomainEvent $event)
    {
        $reflection = new ReflectionClass($event);
        $method = "apply" . $reflection->getShortName();

        return static::$method($state, $event);
    }
}
