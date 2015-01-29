<?php namespace KBC\EventSourcing;

use KBC\EventSourcing\Events\DomainEvent;

trait Replayer {

    public static function replayEvents($events)
    {
        $object = (new \ReflectionClass(static::class))->newInstanceWithoutConstructor();

        foreach ($events as $event)
        {
            $object->apply($event);
        }

        return $object;
    }

    private function apply(DomainEvent $event)
    {
        $classParts = explode('\\', get_class($event));

        $method = "apply" . array_pop($classParts);

        $this->$method($event);
    }

}