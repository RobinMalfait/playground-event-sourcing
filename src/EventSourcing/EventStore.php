<?php namespace Acme\EventSourcing;

use Acme\EventSourcing\Events\Dispatcher;
use Acme\EventSourcing\Serialization\Deserializer;
use Acme\EventSourcing\Serialization\Serializer;
use Acme\Storages\EventStorage;
use ReflectionClass;

final class EventStore
{
    use Serializer, Deserializer;

    protected $storage;

    protected $dispatcher;

    public function __construct(EventStorage $storage, Dispatcher $dispatcher)
    {
        $this->storage = $storage;
        $this->dispatcher = $dispatcher;
    }

    public function save($aggregate)
    {
        $events = $aggregate->releaseEvents();

        foreach ($events as $event) {
            $aggregate->applyAnEvent($event);

            $this->storage->storeEvent(
                $event->getAggregateId(),
                $aggregate->version,
                $this->serialize($event)
            );
        }

        $this->dispatcher->dispatch((new ReflectionClass($aggregate))->getName(), $events);
    }

    /**
     * @param $id
     * @return array
     */
    public function getEventsFor($id)
    {
        return $this->storage->searchEventsFor($id, function ($data) {
            return $this->deserialize($data);
        });
    }
}
