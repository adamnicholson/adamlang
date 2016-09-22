<?php

namespace Adamnicholson\Adamlang\Functions;

use Adamnicholson\Adamlang\Input;
use Adamnicholson\Adamlang\Interpreter;
use Adamnicholson\Adamlang\Lexer;
use Adamnicholson\Adamlang\Output;
use Adamnicholson\Adamlang\Token;

class PerhapsFunction
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
     * PerhapsFunction constructor.
     * @param Input $input
     * @param Output $output
     */
    public function __construct(Input $input, Output $output)
    {
        $this->input = $input;
        $this->output = $output;
    }

    /**
     * @param $expression
     * @param $true
     * @param $false
     * @return mixed
     */
    public function __invoke($expression, $true, $false)
    {
        return $this->getValue($expression)
            ? $this->getValue($true)
            : $this->getValue($false);
    }

    private function getValue($expression)
    {
        if ($expression instanceof Token) {
            (new Interpreter)->evaluateExpression($expression, $this->input, $this->output);
        }

        return $expression;
    }
}