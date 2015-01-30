<?php namespace KBC\EventSourcing\Events;

use ReflectionClass;

final class Dispatcher {

    private $listeners = [];

    private $projectors = [];

    public function dispatch($class, $event)
    {
        if (is_array($event))
        {
            foreach($event as $e)
            {
                $this->dispatch($class, $e);
            }
            return;
        }

        $this->fireEvent($event);
        $this->project($class, $event);
    }

    public function addProjector($name, $projector)
    {
        $this->projectors[$name][] = $projector;
    }

    public function addListeners($name, $listeners)
    {
        foreach($listeners as $listener)
        {
            $this->addListener($name, $listener);
        }
    }

    public function addListener($name, Listener $listener)
    {
        $this->listeners[$name][] = $listener;
    }

    private function project($model, $event)
    {
        foreach($this->projectors[$model] as $projector)
        {
            $method = 'project' .(new ReflectionClass($event))->getShortName();

            $projector->$method($event);
        }
    }

    private function fireEvent(DomainEvent $event)
    {
        $listeners = $this->getListeners(get_class($event));

        if ( ! $listeners)
        {
            return;
        }

        foreach ($listeners as $listener)
        {
            $listener->handle($event);
        }
    }

    private function getListeners($name)
    {
        if ( ! $this->hasListeners($name))
        {
            return;
        }

        return $this->listeners[$name];
    }

    private function hasListeners($name)
    {
        return isset($this->listeners[$name]);
    }
}