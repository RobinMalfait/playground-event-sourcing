<?php namespace Docs;

class MarkdownFormatter implements Formatter
{
    protected $scenario;

    protected $given;

    protected $when;

    protected $then;

    protected $template;

    public function __construct()
    {
        $this->template = $this->getTemplate();
    }


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
        return $this->parseTemplate([
            'scenario' => $this->scenario,
            'given' => $this->getGiven($given),
            'when' => $this->getWhen($when),
            'assertions' => $this->getAssertions($then),
            'date' => (new \DateTime())->format("d-m-Y")
        ]);
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
                : $text . ' of __*' . $param['value'] . '*__, ';
        }

        if ($round == 0) {
            return rtrim($text, ', ') . '.';
        }

        return $text;
    }

    private function getGiven($given)
    {
        if (empty($given)) {
            return '/';
        }

        return implode(PHP_EOL, array_map(function ($event) {
            return "- " . $event['name'] . " with " . $this->parseParameters($event['parameters']);
        }, $given));
    }

    private function getWhen($when)
    {
        return $when['name'] . " with " . $this->parseParameters($when['parameters']);
    }

    private function getAssertions($assertions)
    {
        return implode(PHP_EOL, array_map(function ($event) {
            return "- <font style='color: " . ($event['status'] == 0 ? 'green' : 'red') . " !important;'>" . $event['name'] . '.</font>';
        }, $assertions));
    }

    /**
     * @return string
     */
    private function getTemplate()
    {
        return file_get_contents(realpath('./tests/Docs/' . $this->getExtension() . '.tpl'));
    }

    private function parseTemplate($data)
    {
        $template = $this->template;

        foreach ($data as $key => $value) {
            $template = str_replace("{{" . $key . "}}", $value, $template);
        }

        return $template;
    }
}
