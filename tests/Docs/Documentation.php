<?php namespace Docs;

use ReflectionClass;

class Documentation
{
    protected $docsFolder;

    protected $formatters;

    public function __construct($docsFolder, $formatters)
    {
        $formatters = is_array($formatters) ? $formatters : [$formatters];

        foreach ($formatters as $formatter) {
            if ($formatter instanceof Formatter) {
                $this->formatters[] = $formatter;
            }
        }

        $this->docsFolder = trim($docsFolder, '/') . '/';

        $this->makeDocsFolder();
    }

    public function generateFor($object, $tests)
    {
        list($filename, $folder) = $this->getObjectInformation($object);
        $this->setScenario($this->createScenarioDescription($filename));

        $given = $this->parseGiven($object->given());
        $when = $this->parseWhen($object->when());
        $then = $this->parseThen($tests);

        $this->writeDocumentation($given, $when, $then, $folder, $filename);
    }

    private function makeDocsFolder()
    {
        if (! file_exists($this->docsFolder)) {
            mkdir($this->docsFolder, 0777, true);
        }
    }

    /**
     * @param $given
     * @param $when
     * @param $then
     * @param $directory
     * @param $filename
     */
    private function writeDocumentation($given, $when, $then, $directory, $filename)
    {
        foreach ($this->formatters as $formatter) {
            $folder = $this->docsFolder . $formatter->getExtension() . '/' . $directory . '/';

            if (! file_exists($folder)) {
                mkdir($folder, 0777, true);
            }

            file_put_contents(
                $folder . $filename . "." . $formatter->getExtension(),
                $formatter->render($given, $when, $then)
            );
        }
    }

    private function createScenarioDescription($class)
    {
        return trim(ucfirst(str_replace(
            'test', '',
            $this->slug($class, ' '))
        ));
    }

    private function parseGiven($given)
    {
        $rows = [];
        foreach ($given as $event) {
            list($name, $parameters) = $this->parseClassWithParameters($event);

            $rows[] = [
                'name' => $name,
                'parameters' => $parameters
            ];
        }

        return $rows;
    }

    private function parseWhen($when)
    {
        list($name, $parameters) = $this->parseClassWithParameters($when);

        return [
            'name' => $name,
            'parameters' => $parameters
        ];
    }


    private function parseThen($tests)
    {
        return array_map(function ($test) {
            $test['name'] = trim(ucfirst(str_replace("_", " ", $test['name'])));

            return $test;
        }, $tests);
    }

    private function parseParameters($className, $class)
    {
        $reflection = new ReflectionClass($className);

        $parameters = $reflection->getConstructor()->getParameters();

        $data = [];

        foreach ($parameters as $param) {
            $property = $reflection->getProperty($param->name);
            $property->setAccessible(true);
            $property = $property->getValue($class);

            $value = ! $param->getClass()
                ? $property
                : $this->parseParameters(
                    get_class($property),
                    $property
                );

            $data[] = [
                'name' => $this->slug($param->name, ' '),
                'value' => $value
            ];
        }

        return $data;
    }

    private function slug($input, $delimiter = '_')
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);

        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }

        return implode($delimiter, $ret);
    }

    /**
     * @param $class
     * @return array
     */
    private function parseClassWithParameters($class)
    {
        $parts = explode('\\', get_class($class));
        $className = ucfirst($this->slug($parts[count($parts) - 1], ' '));

        return [$className, $this->parseParameters(get_class($class), $class)];
    }

    private function setScenario($scenario)
    {
        foreach ($this->formatters as $formatter) {
            $formatter->setScenario($scenario);
        }
    }

    private function getObjectInformation($object)
    {
        $class = get_class($object);

        $folder = explode("\\", $class);
        $testFile = $folder[count($folder) - 1];

        $filename = $this->slug($testFile);
        unset($folder[count($folder) - 1]);

        return [$filename, implode('/', $folder)];
    }
}
