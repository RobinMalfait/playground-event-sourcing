<?php namespace KBC\Core;

use KBC\EventSourcing\Events\EventGenerator;
use KBC\EventSourcing\Replayer;

abstract class BaseModel
{
    use EventGenerator, Replayer;

    public $playhead = -1;
}
