<?php namespace KBC\EventSourcing;

class EventStoreRepository implements EventSourcingRepository
{
    protected $eventStore;

    /**
     * @param EventStore $eventStore
     */
    public function __construct(EventStore $eventStore)
    {
        $this->eventStore = $eventStore;
    }

    /**
     * @param $id
     * @return array
     */
    public function load($id)
    {
        return $this->eventStore->getEventsFor($id);
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
