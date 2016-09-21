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
     * @return mixed
     *  The return value of the last function which ran
     */
    public function run(Stream $stream, Input $input, Output $output)
    {
        $script = '';
        while (!$stream->ended()) {
            $script .= $stream->read();
        }

        return $this->evaluateExpression(new Token(Token::T_EXPRESSION, $script), $input, $output);
    }

    private function evaluateExpression(Token $expr, Input $input, Output $output)
    {
        $stream = new InMemoryIO($expr->getValue());

        $container = new Container;
        $container->instance(Input::class, $input);
        $container->instance(Output::class, $output);
        $container->instance(Stream::class, $stream);

        /** @var Tokenizer $tokenizer */
        $tokenizer = $container->make(Tokenizer::class);
        $container->instance(Tokenizer::class, $tokenizer);

        $prev = new Token(Token::T_BOF, "");
        $returns = null;

        while (true) {

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

                    $args = [];

                    $prev = $tokenizer->next($prev); // may be T_ARG_SEPARATOR or T_EOL or T_EOF

                    while ($prev->getType() === Token::T_FUNCTION_ARG_SEPARATOR) {

                        $prev = $tokenizer->next($prev); // get the ARGUMENT, ie. the thing after the T_ARG_SEPARATOR

                        if ($prev->getType() === Token::T_STRING_LITERAL) {
                            $args[] = $prev->getValue();
                        } elseif ($prev->getType() === Token::T_EXPRESSION) {
                            $args[] = $this->evaluateExpression($prev, $input, $output);
                        } elseif ($prev->getType() === Token::T_INLINE_EXPRESSION) {
                            $args[] = function () use ($prev, $input, $output) {
                                $this->evaluateExpression($prev, $input, $output);
                            };
                        } else {
                            throw new \RuntimeException("Only " . Token::T_STRING_LITERAL . " can be passed to functions - given " . $prev->getType());
                        }

                        $prev = $tokenizer->next($prev);
                    }

                    $returns = call_user_func_array([$fn, '__invoke'], $args);

                    break;

                default:
                    throw new \RuntimeException("Unexpected " . $prev->getType());
            }
        }

        return $returns;
    }
}