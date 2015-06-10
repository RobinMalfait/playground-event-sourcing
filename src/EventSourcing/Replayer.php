<?php namespace KBC\EventSourcing;

use KBC\EventSourcing\Events\DomainEvent;
use ReflectionClass;

trait Replayer
{
    public static function replayEvents($events)
    {
        $state = null;

        foreach ($events as $event) {
            $state = self::applyAnEvent($state, $event);
        }

        return $state;
    }

    private static function applyAnEvent($state, DomainEvent $event)
    {
        $reflection = new ReflectionClass($event);
        $method = "apply" . $reflection->getShortName();

        return static::$method($state, $event);
    }
}
