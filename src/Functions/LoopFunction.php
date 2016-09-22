<?php

namespace Adamnicholson\Adamlang\Functions;

use Adamnicholson\Adamlang\Input;
use Adamnicholson\Adamlang\Interpreter;
use Adamnicholson\Adamlang\Lexer;
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
        

        for ($i=1; $i<=$repeat; $i++) {

            $fn = new Token(
                Token::T_INLINE_EXPRESSION,
                new Lexer(clone $callback->getValue()->getStream())
            );

            (new Interpreter)->evaluateExpression($fn, $this->input, $this->output);
        }
    }
}