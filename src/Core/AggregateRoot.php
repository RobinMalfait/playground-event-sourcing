<?php namespace KBC\Core;

use KBC\EventSourcing\Events\EventGenerator;
use KBC\EventSourcing\Replayer;

abstract class AggregateRoot
{
    use EventGenerator, Replayer;

    public $playhead = -1;
}
