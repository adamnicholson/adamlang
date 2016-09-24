<?php

namespace Adamnicholson\Adamlang\Functions;

use Adamnicholson\Adamlang\AssignmentScope;
use Adamnicholson\Adamlang\Context;
use Adamnicholson\Adamlang\Input;
use Adamnicholson\Adamlang\Interpreter;
use Adamnicholson\Adamlang\Lexer;
use Adamnicholson\Adamlang\Output;
use Adamnicholson\Adamlang\Token;

class LoopFunction
{
    /**
     * @var Context
     */
    private $context;

    /**
     * LoopFunction constructor.
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    public function __invoke(int $repeat, Token $callback)
    {
        for ($i=0; $i<$repeat; $i++) {

            $fn = new Token(
                Token::T_EXPRESSION,
                new Lexer(clone $callback->getValue()->getStream())
            );

            $context = $this->context->withChangedScope(function (AssignmentScope $scope) use ($i) {
                $scope->values['i'] = $i;
                return $scope;
            });

            (new Interpreter)->evaluateExpression($fn, $context);
        }
    }
}