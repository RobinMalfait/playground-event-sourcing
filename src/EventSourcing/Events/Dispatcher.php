<?php namespace KBC\EventSourcing\Events;

final class Dispatcher {

    private $listeners = [];

    public function dispatch($event)
    {
        if (is_array($event))
        {
            array_map(function($e) {
                $this->dispatch($e);
            }, $event);
            return;
        }

        $this->fireEvent($event);
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