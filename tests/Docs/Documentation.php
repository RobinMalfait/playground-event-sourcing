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
        foreach ($given as $event) {
            $rows[] = $this->parseClassWithParameters($event);
        }

        return $rows;
    }

    private function parseWhen($when)
    {
        return $this->parseClassWithParameters($when);
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
            $value = "";

            if ( ! $param->getClass()) {
                $value = $class->{$param->name};
            }

            $data[] = $this->slug($param->name, ' ') . ' of ' . $value;
        }

        if (count($data) > 0) {
            $output = " with " . PHP_EOL . PHP_EOL;

            foreach($data as $param) {
                $output .= "\t - " . $param . PHP_EOL;
            }


            return $output;
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
