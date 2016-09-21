<?php

namespace Adamnicholson\Adamlang;

use Illuminate\Container\Container;

class Interpreter
{
    /**
     * @param Stream $stream
     *
     * @param Input $input
     *
     * @param Output $output
     *
     * @return int
     * Exit code. 0 for success, 1 for generic error.
     */
    public function run(Stream $stream, Input $input, Output $output): int
    {
        $container = new Container;
        $container->instance(Input::class, $input);
        $container->instance(Output::class, $output);
        $container->instance(Stream::class, $stream);

        /** @var Tokenizer $tokenizer */
        $tokenizer = $container->make(Tokenizer::class);
        $container->instance(Tokenizer::class, $tokenizer);

        $prev = new Token(Token::T_BOF, "");

        while (!$stream->ended()) {

            switch ($prev->getType()) {

                case Token::T_EOF:
                    break 2;

                case Token::T_BOF:
                case Token::T_EOL:
                    $prev = new Token(Token::T_BOL);
                    break;

                case Token::T_BOL:
                    $prev = $tokenizer->next($prev); // should be function
                    break;

                case Token::T_FUNCTION:

                    $class = __NAMESPACE__."\\Functions\\" . $prev->getValue() . "Function";
                    if (!class_exists($class)) {
                        throw new \RuntimeException("Function " . $prev->getValue() . " does not exist at " . $class);
                    }
                    $fn = $container->make($class);
                    $prev = $fn->__invoke($prev);

                    break;

                default:
                    throw new \RuntimeException("Unexpected " . $prev->getType());
            }

        }

        return 0;
    }
}