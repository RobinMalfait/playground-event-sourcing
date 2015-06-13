<?php namespace Docs;

class MarkdownFormatter implements Formatter
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
        return 'md';
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
        $text = "## Scenario:" . PHP_EOL . PHP_EOL;
        $text .= "> " . $this->scenario . PHP_EOL . PHP_EOL;

        $text .= "### Given:" . PHP_EOL . PHP_EOL;

        if (! empty($given)) {
            foreach ($given as $event) {
                $text .= "- " . $event['name'] . " with ";

                $text .= $this->parseParameters($event['parameters']) . PHP_EOL;
            }
        } else {
            $text .= "/" . PHP_EOL;
        }

        $text .= PHP_EOL . "### When:" . PHP_EOL . PHP_EOL;
        $text .=  $when['name'] . " with " . $this->parseParameters($when['parameters']) . PHP_EOL . PHP_EOL;

        $text .= "### Then:" . PHP_EOL . PHP_EOL;
        foreach ($then as $event) {
            $text .= "- <font style='color: " . ($event['status'] == 0 ? 'green' : 'red') . " !important;'>" . $event['name'] . '.</font>' . PHP_EOL;
        }

        $text .= PHP_EOL . "---" . PHP_EOL . "*Rendered " . (new \DateTime())->format("d-m-Y") . ".*";

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
