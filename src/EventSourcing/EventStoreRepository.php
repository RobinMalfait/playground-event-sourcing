<?php namespace KBC\EventSourcing;

class EventStoreRepository implements EventSourcingRepository
{
    protected $eventStore;

    protected $aggregateClass;

    /**
     * @param EventStore $eventStore
     * @internal param $aggregateClass
     */
    public function __construct(EventStore $eventStore)
    {
        $this->eventStore = $eventStore;
    }

    /**
     * @param $class
     * @return mixed
     */
    public function setAggregateClass($class)
    {
        $this->aggregateClass = $class;
    }

    /**
     * @param $id
     * @return array
     * @throws AggregateClassNotFoundException
     */
    public function load($id)
    {
        $subject = $this->aggregateClass;

        if (! $subject) {
            throw new AggregateClassNotFoundException();
        }

        return $subject::replayEvents($this->eventStore->getEventsFor($id));
    }

    /**
     * @param $aggregateRoot
     * @return mixed
     */
    public function save($aggregateRoot)
    {
        $this->eventStore->save($aggregateRoot);
    }
}
