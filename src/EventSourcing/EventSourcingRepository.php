<?php namespace KBC\EventSourcing;

interface EventSourcingRepository
{
    /**
     * @param $id
     * @return array
     */
    public function load($id);

    /**
     * @param $aggregateRoot
     * @return mixed
     */
    public function save($aggregateRoot);
}
