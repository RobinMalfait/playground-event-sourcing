<?php namespace KBC\Core;

use KBC\EventSourcing\Events\EventGenerator;
use KBC\EventSourcing\Replayer;

abstract class BaseModel {

    public $id;

    use EventGenerator, Replayer;

}