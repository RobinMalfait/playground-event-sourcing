<?php namespace Docs;

class TextFormatter implements Formatter
{
    protected $scenario;

    protected $given;

    protected $when;

    protected $then;

    protected $separator = "  ";

    /**
     * Get an extension
     *
     * @return string
     */
    public function getExtension()
    {
        return 'txt';
    }

    /**
     * Set the scenario title
     *
     * @param $scenario
     * @return void
     */
    public function setScenario($scenario)
    {
        $this->scenario = $scenario;
    }


    /**
     * Render documentation
     *
     * @param $given
     * @param $when
     * @param $then
     * @return string
     */
    public function render($given, $when, $then)
    {
        $text = "Scenario: " . $this->scenario . PHP_EOL . PHP_EOL;

        $text .= "Given:" . PHP_EOL;

        if (! empty($given)) {
            foreach ($given as $event) {
                $text .= $this->separator . $event['name'] . " with ";

                $text .= $this->parseParameters($event['parameters']) . PHP_EOL;
            }
        } else {
            $text .= $this->separator . "/" . PHP_EOL;
        }

        $text .= PHP_EOL . "When:" . PHP_EOL . $this->separator . $when['name'] . " with " . $this->parseParameters($when['parameters']) . PHP_EOL . PHP_EOL;

        $text .= "Then:" . PHP_EOL;
        foreach ($then as $event) {
            $text .= $this->separator . $event['name'] . "." . PHP_EOL;
        }

        $text .= PHP_EOL . "Rendered " . (new \DateTime())->format("d-m-Y") . ".";

        return $text . PHP_EOL;
    }

    /**
     * @param $parameters
     * @param int $round
     * @return string
     */
    private function parseParameters($parameters, $round = 0)
    {
        $text = "";
        foreach ($parameters as $param) {
            if (! is_array($param['value'])) {
                $text .= $param['name'];
            }

            $text = is_array($param['value'])
                ? $text . $this->parseParameters($param['value'], $round + 1)
                : $text . ' of ' . $param['value'] . ', ';
        }

        if ($round == 0) {
            return rtrim($text, ', ') . '.';
        }

        return $text;
    }
}
