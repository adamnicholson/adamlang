<?php

namespace Adamnicholson\Adamlang\Functions;

use Adamnicholson\Adamlang\Output;

class ShoutFunction
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

    public function __invoke(...$strings)
    {
        $this->output->write(strtoupper(implode('', $strings)));
    }
}