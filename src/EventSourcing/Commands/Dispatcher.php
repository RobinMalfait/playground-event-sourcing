<?php namespace KBC\EventSourcing\Commands;

class Dispatcher
{
    public function dispatch($command)
    {
        return $this->getHandlerFor($command)->handle($command);
    }

    private function getHandlerFor($command)
    {
        $handler = get_class($command) . "Handler";

        return app()->make($handler);
    }
}
