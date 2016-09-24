<?php

namespace Adamnicholson\Adamlang\Functions;

use Adamnicholson\Adamlang\Assignments;
use Adamnicholson\Adamlang\InterpreterContext;
use Adamnicholson\Adamlang\Input;
use Adamnicholson\Adamlang\Interpreter;
use Adamnicholson\Adamlang\Lexer;
use Adamnicholson\Adamlang\Output;
use Adamnicholson\Adamlang\Token;

class LoopFunction
{
    /**
     * @var InterpreterContext
     */
    private $context;

    /**
     * LoopFunction constructor.
     * @param InterpreterContext $context
     */
    public function __construct(InterpreterContext $context)
    {
        $this->context = $context;
    }

    public function __invoke($repeat, Token $callback)
    {
        $range = $this->getRange($repeat);

        for ($i=$range[0]; $i<=$range[1]; $i++) {

            $fn = new Token(
                Token::T_EXPRESSION,
                new Lexer(clone $callback->getValue()->getStream())
            );

            $context = $this->context->withChangedScope(function (Assignments $scope) use ($i) {
                $scope->values['i'] = $i;
                return $scope;
            });

            (new Interpreter)->evaluateExpression($fn, $context);
        }
    }

    private function getRange($repeat)
    {
        if ($repeat instanceof Token && $repeat->getType() === Token::T_INTEGER_RANGE) {
            return $repeat->getValue();
        }

        if (is_int($repeat)) {
            return [0, $repeat-1];
        }

        throw new \RuntimeException("First argument to loop must be an integer or integer range, given " . gettype($repeat));
    }
}