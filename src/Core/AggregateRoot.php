<?php namespace Acme\Core;

use Acme\EventSourcing\Events\EventGenerator;
use Acme\EventSourcing\Replayer;

abstract class AggregateRoot
{
    use EventGenerator, Replayer;

    public $version = -1;
}
