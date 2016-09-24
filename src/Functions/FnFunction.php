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


    public function __invoke(...$args)
    {
        $name = array_shift($args);

        $callback = array_pop($args);

        $requiredArgs = $args;

        $this->scope->functions[$name] = function (...$args) use ($name, $callback, $requiredArgs) {

            if (count($args) !== count($requiredArgs)) {
                throw new \RuntimeException(
                    "$name requires " . count($requiredArgs) . " arguments; " . count($args) . " given"
                );
            }

            $context = $this->context->withChangedScope(function (Assignments $assignments) use ($requiredArgs, $args) {
                while (count($args) > 0) {
                    $assignments->values[array_shift($requiredArgs)] = array_shift($args);
                }
                return $assignments;
            });

            return (new Interpreter)->evaluateExpression($callback, $context);
        };
    }
}