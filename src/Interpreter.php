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
        $container->instance(Interpreter::class, $this);

        $prev = new Token(Token::TYPE_BOF, "");

        while (!$stream->ended()) {

            $token = $this->next($prev, $stream);

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

    public function next(Token $previous, Stream $stream): Token
    {
        switch ($previous->getType()) {
            case Token::TYPE_BOF:
                return new Token(Token::TYPE_FUNCTION, $this->readTil($stream, " "));
                break;

            case Token::TYPE_FUNCTION:
                return new Token(Token::TYPE_FUNCTION_ARG_SEPARATOR, $this->readTil($stream, '"'));
                break;

            case Token::TYPE_FUNCTION_ARG_SEPARATOR:
                $stream->read(); // "
                $token = new Token(Token::TYPE_STRING_LITERAL, $this->readTil($stream, '"'));
                $stream->read(); // "
                return $token;
                break;

            default:
                throw new \RuntimeException("Unexpected token");

        }
    }

    private function readTil(Stream $stream, string $ends)
    {
        $value = "";

        while (($char = $stream->peek()) != $ends) {

            if ($stream->ended()) {
                throw new \RuntimeException("Unexpected end of stream after $value");
            }

            $value .= $stream->read();
        }

        return $value;
    }
}