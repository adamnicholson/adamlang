<?php

namespace Adamnicholson\Adamlang\Functions;

use Adamnicholson\Adamlang\Output;

class HelloWorldFunction
{
    /**
     * @var Output
     */
    private $output;

    /**
     * @param Output $output
     */
    public function __construct(Output $output)
    {
        $this->output = $output;
    }

    public function __invoke()
    {
        $this->output->write("hello world");
    }
}