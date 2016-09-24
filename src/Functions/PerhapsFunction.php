<?php

namespace Adamnicholson\Adamlang\Functions;

use Adamnicholson\Adamlang\Context;
use Adamnicholson\Adamlang\Interpreter;
use Adamnicholson\Adamlang\Token;

class PerhapsFunction
{
    /**
     * @var Context
     */
    private $context;

    /**
     * PerhapsFunction constructor.
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        $this->context = $context;
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
            (new Interpreter)->evaluateExpression($expression, $this->context);
        }

        return $expression;
    }
}