<?php

use KBC\EventSourcing\EventSourcingRepository;

abstract class Specification extends PHPUnit_Framework_TestCase
{
    protected $documentation;

    protected $exception;

    protected $producedEvents = [];

    /**
     * Current state
     *
     * @var
     */
    protected $state;

    /**
     * Given events
     *
     * @return array
     */
    abstract public function given();

    /**
     * @return Command
     */
    abstract public function when();

    /**
     * @param $repository
     * @return mixed
     */
    abstract public function handler($repository);

    public function setUp()
    {
        try {
            $events = $this->given();

            $fakeRepository = new FakeRepository($events);

            $this->handler($fakeRepository)->handle($this->when());

            $this->producedEvents = $fakeRepository->produced;

            $this->state = $fakeRepository->state;
        } catch (Exception $e) {
            $this->exception = $e;
        }
    }
}

class FakeRepository implements EventSourcingRepository
{
    protected $previousEvents;

    public $produced;

    public $state;

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

        $this->buildNewState($aggregate);
    }

    private function buildNewState($aggregate)
    {
        $class = get_class($aggregate);

        $this->state = call_user_func([$class, 'replayEvents'], array_merge(
            $this->previousEvents,
            $this->produced
        ));
    }
}
