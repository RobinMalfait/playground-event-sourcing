<?php namespace KBC\Storages;

interface EventStorage {

    public function storeEvent($rootId, $event);

    public function loadAll();

    public function searchEventsFor($id, Callable $map);

}