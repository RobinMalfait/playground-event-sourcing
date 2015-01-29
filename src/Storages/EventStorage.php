<?php namespace KBC\Storages;

interface EventStorage {

    public function storeEvent($event);

    public function loadAll();

    public function searchEventsFor($id, Callable $map);

}