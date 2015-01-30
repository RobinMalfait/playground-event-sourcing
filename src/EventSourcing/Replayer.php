<?php namespace KBC\EventSourcing;

use KBC\EventSourcing\Events\DomainEvent;

trait Replayer {

    public static function replayEvents($events)
    {
        $state = null;

        foreach ($events as $event)
        {
            $state = static::apply($state, $event);
        }

        return $state;
    }

    private static function apply($state, DomainEvent $event)
    {
        $classParts = explode('\\', get_class($event));

        $method = "apply" . array_pop($classParts);

        return static::$method($state, $event);
    }

}