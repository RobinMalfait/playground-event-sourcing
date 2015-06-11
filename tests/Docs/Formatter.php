<?php namespace Docs;

interface Formatter
{
    /**
     * Get an extension
     *
     * @return string
     */
    public function getExtension();

    /**
     * Set the scenario title
     *
     * @param $scenario
     * @return void
     */
    public function setScenario($scenario);


    /**
     * Render documentation
     *
     * @param $given
     * @param $when
     * @param $then
     * @return string
     */
    public function render($given, $when, $then);
}
