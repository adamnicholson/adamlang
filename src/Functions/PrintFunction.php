<?php

namespace Adamnicholson\Adamlang\Functions;

use Adamnicholson\Adamlang\Output;

class PrintFunction
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
        foreach ($strings as $string) {
            if (!is_string($string)) {
                throw new \RuntimeException("Only strings may be printed, given " . gettype($string));
            }
        }

        $this->output->write(implode('', $strings));
    }
}