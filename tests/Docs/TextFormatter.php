<?php namespace Docs;

class TextFormatter implements Formatter
{
    protected $scenario;

    protected $given;

    protected $when;

    protected $then;

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

        $text .= "Given: ";

        if (! empty($given)) {
            $text .= PHP_EOL;

            foreach ($given as $event) {
                $text .= "\t" . $event['name'] . " with " . PHP_EOL;

                $text .= $this->parseParameters($event['parameters']) . PHP_EOL;
            }
        } else {
            $text .= "/" . PHP_EOL . PHP_EOL;
        }

        $text .= "When:" . PHP_EOL;
        $text .= "\t" . $when['name'] . PHP_EOL;
        $text .= $this->parseParameters($when['parameters']) . PHP_EOL;

        $text .= "Expect:" . PHP_EOL;
        foreach ($then as $event) {
            $text .= "- " . $event . PHP_EOL;
        }

        $text .= PHP_EOL . PHP_EOL . "Rendered " . (new \DateTime())->format("d-m-Y");

        return $text . PHP_EOL;
    }

    /**
     * @param $parameters
     * @param int $level
     * @return string
     */
    private function parseParameters($parameters, $level = 1)
    {
        $text = "";
        foreach ($parameters as $param) {
            for ($i = 0; $i <= $level; $i++) {
                $text .= "\t";
            }

            $text .= $param['name'];

            $text = is_array($param['value'])
                ? $text . PHP_EOL . $this->parseParameters($param['value'], $level + 1)
                : $text . ' of ' . $param['value'];

            $text .= PHP_EOL;
        }

        return $text;
    }
}
