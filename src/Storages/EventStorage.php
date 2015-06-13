<?php namespace KBC\Storages;

interface EventStorage
{
    public function storeEvent($rootId, $playhead, $event);

    public function loadAll();

    public function searchEventsFor($id, callable $map);
}
