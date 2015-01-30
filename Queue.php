<?php

use Pheanstalk\Pheanstalk;
use SuperClosure\Serializer;

final class Queue {

    protected $pheanstalk;

    protected $serializer;

    public function __construct($address = '127.0.0.1', $tube = 'default') {
        $this->pheanstalk = new Pheanstalk($address);
        $this->pheanstalk->useTube($tube);
        $this->serializer = new Serializer();

        $this->run($tube);
    }

    public function push(Closure $callback)
    {
        $data = $this->serializer->serialize($callback);
        $this->pheanstalk->put($data);
    }

    public function run($tube)
    {
        $job = $this->pheanstalk->watch($tube)->reserve();
        $cb = $this->serializer->unserialize($job->getData());

        $cb($job);

        $this->pheanstalk->delete($job);
    }

}