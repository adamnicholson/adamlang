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

        $prev = new Token(Token::TYPE_BOF, "");

        while (!$stream->ended()) {

            $token = $tokenizer->next($prev);

            if ($token->getType() === Token::TYPE_EOF) {
                break;
            }

            switch ($token->getType()) {
                case Token::TYPE_FUNCTION:

                    $class = __NAMESPACE__."\\Functions\\" . $token->getValue() . "Function";
                    if (!class_exists($class)) {
                        throw new \RuntimeException("Function " . $token->getValue() . " does not exist at " . $class);
                    }
                    $fn = $container->make($class);
                    $fn->__invoke($token);

                    break;

                default:
                    throw new \RuntimeException("Unexpected token " . $token->getType() . " with value " . $token->getValue());
            }

            $prev = $token;
        }

        return 0;
    }
}