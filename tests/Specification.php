<?php

use KBC\EventSourcing\EventSourcingRepository;

abstract class Specification extends PHPUnit_Framework_TestCase
{
    protected $documentation;

    protected $exception;

    protected $producedEvents = [];

    abstract public function given();

    abstract public function when();

    abstract public function handler($repository);

    public function setUp()
    {
        try {
            $events = $this->getGiven();

            $fakeRepository = new FakeRepository($events);

            $this->handler($fakeRepository)->handle($this->when());

            $this->producedEvents = $fakeRepository->produced;
        } catch (Exception $e) {
            $this->exception = $e;
        }
    }

    /**
     * @return array
     */
    private function getGiven()
    {
        $events = $this->given();

        if (! is_array($events)) {
            $events = [$events];
        }

        return $events;
    }
}

class FakeRepository implements EventSourcingRepository
{
    protected $previousEvents;

    public $produced;

    public function __construct($events)
    {
        $this->previousEvents = $events;
    }

    public function load($id)
    {
        return $this->previousEvents;
    }


    public function save($aggregate)
    {
        $this->produced = $aggregate->releaseEvents();
    }
}
