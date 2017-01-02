<?php namespace KBC\EventSourcing;

use KBC\EventSourcing\Events\Dispatcher;
use KBC\EventSourcing\Serialization\Deserializer;
use KBC\EventSourcing\Serialization\Serializer;
use KBC\Storages\EventStorage;
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
        }

        $rootId = $aggregate->id;

        foreach ($events as $event) {
            $this->storage->storeEvent($rootId, $aggregate->version, $this->serialize($event));
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
