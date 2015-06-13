<?php

use Docs\Documentation;
use Docs\MarkdownFormatter;
use Docs\TextFormatter;
use KBC\EventSourcing\AggregateClassNotFoundException;
use KBC\EventSourcing\EventSourcingRepository;

abstract class Specification extends PHPUnit_Framework_TestCase
{
    /**
     *
     */
    protected $caughtException;

    /**
     * @var array
     */
    protected $producedEvents = [];

    /**
     * Current state
     *
     * @var
     */
    protected $aggregate;

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

    protected static $tests = [];

    public static function setUpBeforeClass()
    {
        static::$tests = [];
    }


    public function tearDown()
    {
        static::$tests[] = [
            'name' => $this->getName(),
            'status' => $this->getStatus()
        ];
    }
    
    public static function tearDownAfterClass()
    {
        $documentation = new Documentation('./docs', [
            new TextFormatter(),
            new MarkdownFormatter()
        ]);

        $documentation->generateFor(new static, static::$tests);
    }

    /**
     * @param Exception $exception
     */
    protected function throws(Exception $exception)
    {
        $this->assertInstanceOf(get_class($exception), $this->caughtException);
    }

    /**
     *
     */
    public function setUp()
    {
        try {
            $events = $this->given();

            $fakeRepository = new FakeRepository($events);

            $this->handler($fakeRepository)->handle($this->when());

            $this->producedEvents = $fakeRepository->produced;
            $this->aggregate = $fakeRepository->aggregate;
        } catch (Exception $e) {
            $this->caughtException = $e;
        }
    }
}

class FakeRepository implements EventSourcingRepository
{
    public $aggregate;

    public $previousEvents;

    public $produced;

    public $aggregateClass;

    public function __construct($events)
    {
        $this->previousEvents = $events;
    }

    /**
     * @param $class
     * @return mixed
     */
    public function setAggregateClass($class)
    {
        $this->aggregateClass = $class;
    }

    public function load($id)
    {
        $subject = $this->aggregateClass;

        if (! $subject) {
            throw new AggregateClassNotFoundException();
        }

        return $subject::replayEvents($this->previousEvents);
    }

    public function save($aggregate)
    {
        $this->produced = $aggregate->releaseEvents();

        foreach ($this->produced as $event) {
            $aggregate->applyAnEvent($event);
        }

        $this->aggregate = $aggregate;
    }
}
