<?php namespace KBC\Storages;

use DateTime;

final class FileStorage implements EventStorage
{
    protected $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function storeEvent($rootId, $event)
    {
        $event = json_encode([
            'aggregate_id' => $rootId,
            'recorded_at' => new DateTime(),
            'data' => $event
        ]);

        $contents = file_get_contents($this->file);

        $contents = (! $contents) ? $contents . $event : $contents . PHP_EOL . $event;

        file_put_contents($this->file, $contents);
    }

    public function loadAll()
    {
        return explode("\n", file_get_contents($this->file));
    }

    public function searchEventsFor($id, callable $map)
    {
        $events = [];

        foreach ($this->loadAll() as $event) {
            $event = $this->objectifyEvent($event);

            if ($event->aggregate_id == $id) {
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
