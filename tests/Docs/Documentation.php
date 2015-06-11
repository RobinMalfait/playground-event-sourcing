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

    public function generateFor($object)
    {
        $class = get_class($object);

        $filename = $this->slug($class);

        $this->setScenario($this->createScenarioDescription($class));

        $given = $this->parseGiven($object->given());

        $when = $this->parseWhen($object->when());

        $then = $this->parseThen();

        $this->writeDocumentation($given, $when, $then, $filename);
    }

    private function makeDocsFolder()
    {
        if (! file_exists($this->docsFolder)) {
            mkdir($this->docsFolder);
        }
    }

    /**
     * @param $given
     * @param $when
     * @param $then
     * @param $filename
     */
    private function writeDocumentation($given, $when, $then, $filename)
    {
        foreach ($this->formatters as $formatter) {
            $folder = $this->docsFolder . $formatter->getExtension() . '/';

            if (! file_exists($folder)) {
                mkdir($folder);
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


    private function parseThen()
    {
        return [];
    }

    private function parseParameters($className, $class)
    {
        $reflection = new ReflectionClass($className);

        $parameters = $reflection->getConstructor()->getParameters();

        $data = [];

        foreach ($parameters as $param) {
            $value = ! $param->getClass()
                ? $class->{$param->name}
                : $this->parseParameters(
                    get_class($class->{$param->name}),
                    $class->{$param->name}
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
}
