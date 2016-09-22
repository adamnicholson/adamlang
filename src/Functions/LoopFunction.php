<?php

namespace Adamnicholson\Adamlang\Functions;

use Adamnicholson\Adamlang\Input;
use Adamnicholson\Adamlang\Interpreter;
use Adamnicholson\Adamlang\Output;
use Adamnicholson\Adamlang\Token;

class LoopFunction
{
    /**
     * @var Input
     */
    private $input;
    /**
     * @var Output
     */
    private $output;

    /**
     * LoopFunction constructor.
     * @param Input $input
     * @param Output $output
     */
    public function __construct(Input $input, Output $output)
    {
        $this->input = $input;
        $this->output = $output;
    }

    public function __invoke(int $repeat, Token $callback)
    {
        $interpreter = new Interpreter;

        for ($i=1; $i<=$repeat; $i++) {
            $callback = clone $callback;
            $interpreter->evaluateExpression($callback, $this->input, $this->output);
        }
    }
}