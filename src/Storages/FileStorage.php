<?php namespace KBC\Storages;

class FileStorage implements EventStorage {

    protected $file = 'storage/events.txt';

    public function storeEvent($event)
    {
        $contents = file_get_contents($this->file);

        file_put_contents($this->file, $contents . $event .  PHP_EOL);
    }

    public function loadAll()
    {
        return explode("\n", file_get_contents($this->file));
    }
}