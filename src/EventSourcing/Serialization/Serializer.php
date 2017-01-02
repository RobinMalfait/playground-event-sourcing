<?php namespace Acme\EventSourcing\Serialization;

use Acme\EventSourcing\Events\DomainEvent;
use ReflectionClass;

trait Serializer
{
    public function serialize(DomainEvent $event)
    {
        $data = $this->serializeRecursively($event);

        return json_encode([get_class($event) => $data]);
    }

    private function serializeRecursively($class)
    {
        $data = [];
        $properties = (new ReflectionClass($class))->getProperties();

        foreach ($properties as $property) {
            $property->setAccessible(true);
            $value = $property->getValue($class);

            if (is_object($value)) {
                $data[$property->getName()] = [
                    'type' => get_class($value),
                    'value' => $this->serializeRecursively($value)
                ];
            } else {
                $data[$property->getName()] = $value;
            }
        }

        return $data;
    }
}
