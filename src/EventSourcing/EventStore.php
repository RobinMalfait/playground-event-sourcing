<?php namespace KBC\EventSourcing;

use KBC\EventSourcing\Events\DomainEvent;
use KBC\EventSourcing\Serialization\Deserializer;
use KBC\EventSourcing\Serialization\Serializer;
use KBC\Storages\EventStorage;

final class EventStore {

    use Serializer, Deserializer;

    protected $storage;

    public function __construct(EventStorage $storage)
    {
        $this->storage = $storage;
    }

    public function save($model)
    {
        $events = $model->releaseEvents();
        $rootId = $model->id;

        array_map(function(DomainEvent $event) use ($rootId)
        {
            $this->storage->storeEvent(json_encode([
                'aggregateId'   => $rootId,
                'data'          => $this->serialize($event)
            ]));
        }, $events);
    }

    /**
     * @param $id
     * @return array
     */
    public function replayFor($id)
    {
        $events = [];
        foreach($this->storage->loadAll() as $event)
        {
            $event = json_decode($event);
            if ($event->aggregateId == $id)
            {
                $events[] = $this->deserialize($event->data);
            }
        }

        return $events;
    }
}