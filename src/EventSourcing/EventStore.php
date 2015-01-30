<?php namespace KBC\EventSourcing;

use KBC\EventSourcing\Events\Dispatcher;
use KBC\EventSourcing\Events\DomainEvent;
use KBC\EventSourcing\Serialization\Deserializer;
use KBC\EventSourcing\Serialization\Serializer;
use KBC\Storages\EventStorage;

final class EventStore {

    use Serializer, Deserializer;

    protected $storage;

    protected $dispatcher;

    public function __construct(EventStorage $storage, Dispatcher $dispatcher)
    {
        $this->storage = $storage;
        $this->dispatcher = $dispatcher;
    }

    public function save($model)
    {
        $events = $model->releaseEvents();
        $rootId = $model->id;

        array_map(function(DomainEvent $event) use ($rootId)
        {
            $this->storage->storeEvent($rootId, $this->serialize($event));
        }, $events);

        $this->dispatcher->dispatch($events);
    }

    /**
     * @param $id
     * @return array
     */
    public function getEventsFor($id)
    {
        return $this->storage->searchEventsFor($id, function($data) {
            return $this->deserialize($data);
        });
    }
}