<?php namespace KBC\Storages;

final class FileStorage implements EventStorage {

    protected $file = 'storage/events.txt';

    public function storeEvent($event)
    {
        $contents = file_get_contents($this->file);

        $contents = ( ! $contents) ? $contents . $event : $contents . PHP_EOL . $event;

        file_put_contents($this->file, $contents);
    }

    public function loadAll()
    {
        return explode("\n", file_get_contents($this->file));
    }

    public function searchEventsFor($id, Callable $map)
    {
        $events = [];
        
        foreach($this->loadAll() as $event)
        {
            $event = $this->objectifyEvent($event);

            if ($event->aggregateId == $id)
            {
                $events[] = $map($event->data);
            }
        }

        return $events;
    }

    private function objectifyEvent($event)
    {
        return json_decode($event);
    }
}