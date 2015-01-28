<?php namespace KBC\Storages;

interface EventStorage {

    public function storeEvent($event);

    public function loadAll();

}