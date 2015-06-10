<?php namespace Docs;

use ReflectionClass;

class Documentation
{
    protected $docsFolder;

    protected $formatter;

    public function __construct($docsFolder, Formatter $formatter)
    {
        $this->formatter = $formatter;
        $this->docsFolder = trim($docsFolder, '/') . '/';

        $this->makeDocsFolder();
    }

    public function generateFor($object)
    {
        $class = get_class($object);

        $filename = $this->slug($class);

        $this->formatter->setScenario($this->createScenarioDescription($class));

        $given = $this->parseGiven($object->given());

        $when = $this->parseClassWithParameters($object->when());

        $then = ["a", "b", "c"];

        $this->writeDocumentation($given, $when, $then, $filename);
    }

    private function makeDocsFolder()
    {
        if (! file_exists($this->docsFolder)) {
            mkdir($this->docsFolder);
        }
    }

    /**
     * @param $filename
     */
    private function writeDocumentation($given, $when, $then, $filename)
    {
        file_put_contents(
            $this->docsFolder . $filename . "." . $this->formatter->getExtension(),
            $this->formatter->render($given, $when, $then)
        );
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
        foreach($given as $event) {
            $rows[] = $this->parseClassWithParameters($event);
        }

        return $rows;
    }

    private function parseParameters($className, $event)
    {
        $reflection = new ReflectionClass($className);

        $parameters = $reflection->getConstructor()->getParameters();

        $data = [];

        foreach($parameters as $param) {
            $data[] = $this->slug($param->name, ' ') . ' of ';
        }

        if (count($data) > 0) {
            return " with " . implode(", ", $data);
        }

        return "";
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

        return $className . $this->parseParameters(get_class($class), $class);
    }
}
