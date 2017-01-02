<?php

use Illuminate\Container\Container;
use KBC\EventSourcing\Commands\Dispatcher;
use Rhumsaa\Uuid\Uuid;

// Setting the container instance
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

function id()
{
    return (String) Uuid::uuid4();
}

function setupDatabase($path, $contents = '')
{
    file_put_contents($path, $contents);
}

function dd()
{
    array_map(function ($x) {
        var_dump($x);
    }, func_get_args());

    die(1);
}
