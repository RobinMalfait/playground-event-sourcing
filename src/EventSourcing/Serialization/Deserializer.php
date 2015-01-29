<?php namespace KBC\EventSourcing\Serialization;

use ReflectionClass;

trait Deserializer {

    public function deserialize($data)
    {
        $data = json_decode($data, true);
        $eventClass = array_keys($data)[0];

        return $this->deserializeRecursively($eventClass, $data[$eventClass]);
    }

    /**
     * @param $class
     * @param $data
     * @return object
     */
    private function deserializeRecursively($class, $data)
    {
        $rc = new ReflectionClass($class);
        $obj = $rc->newInstanceWithoutConstructor();

        foreach($rc->getProperties() as $property)
        {
            $property->setAccessible(true);
            $propertyName = $property->getName();

            $contents = $data[$propertyName];

            if (isset($contents['type'])) {
                $property->setValue($obj,
                    $this->deserializeRecursively(
                        $contents['type'],
                        $contents['value']
                    )
                );
            } else {
                $property->setValue($obj, $data[$propertyName]);
            }
        }

        return $obj;
    }

}