<?php

abstract class Specification extends PHPUnit_Framework_TestCase
{
    protected $documentation;

    protected $type;

    protected $exception;

    protected $events = [];

    abstract public function given();

    abstract public function when();

    public function setUp()
    {
        try {
            $type = $this->type;
            $events = $this->given();

            $sub = $type::replayEvents($events);
            $sub->apply($this->when());
            $this->events = $sub->releaseEvents();

        } catch (Exception $e) {
            $this->exception = $e;
        }
    }

}
