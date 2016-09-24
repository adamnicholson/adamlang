<?php

namespace Adamnicholson\Adamlang\Functions;

use Adamnicholson\Adamlang\Assignments;
use Adamnicholson\Adamlang\Interpreter;
use Adamnicholson\Adamlang\InterpreterContext;
use Adamnicholson\Adamlang\Token;

class FnFunction
{
    /**
     * @var Assignments
     */
    private $scope;
    /**
     * @var InterpreterContext
     */
    private $context;

    /**
     * GetFunction constructor.
     * @param Assignments $scope
     * @param InterpreterContext $context
     */
    public function __construct(Assignments $scope, InterpreterContext $context)
    {
        $this->scope = $scope;
        $this->context = $context;
    }

    public function __invoke($name, Token $callback)
    {
        $this->scope->functions[$name] = function () use ($callback) {
            (new Interpreter)->evaluateExpression($callback, $this->context);
        };
    }
}