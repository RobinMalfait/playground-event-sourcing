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
        $text = "## Scenario:" . PHP_EOL . PHP_EOL;
        $text .= "> " . $this->scenario . PHP_EOL . PHP_EOL;

        $text .= "### Given:" . PHP_EOL . PHP_EOL;
        foreach ($given as $row) {
            dd($row);
            $text .= "- " . $row . PHP_EOL;
        }

        $text .= PHP_EOL . "### When:" . PHP_EOL . PHP_EOL;
        $text .= "- " . $when . PHP_EOL . PHP_EOL;

        $text .= "### Then:" . PHP_EOL . PHP_EOL;
        foreach ($then as $row) {
            $text .= "- " . $row . PHP_EOL;
        }

        $text .= PHP_EOL . "---" . PHP_EOL . "*Rendered " . (new \DateTime())->format("d-m-Y") . ".*";

        return $text . PHP_EOL;
    }
}
