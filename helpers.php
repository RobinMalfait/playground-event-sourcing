<?php

// Setting the container instance
use Illuminate\Container\Container;
use KBC\EventSourcing\Commands\Dispatcher;

Container::setInstance(new Container());

/**
 * Laravel's Container
 *
 * @param null $make
 * @param array $parameters
 * @return mixed|static
 */
function app($make = null, $parameters = [])
{
    if (is_null($make)) {
        return Container::getInstance();
    }

    return Container::getInstance()->make($make, $parameters);
}

// Register the Command Dispatcher
function dispatch($command)
{
    app(Dispatcher::class)->dispatch($command);
}

function dd()
{
    array_map(function ($x) {
        var_dump($x);
    }, func_get_args());

    die(1);
}
