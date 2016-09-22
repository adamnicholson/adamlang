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
        return $this->evaluateExpression(
            new Token(Token::T_EXPRESSION, new Lexer($stream)),
            $input,
            $output
        );
    }

    public function evaluateExpression(Token $expr, Input $input, Output $output)
    {
        $lexer = $expr->getValue();

        $container = new Container;
        $container->instance(Input::class, $input);
        $container->instance(Output::class, $output);

        $scope = (object) [
            'constants' => [
                'true' => true,
                'false' => false,
            ],
        ];


        $prev = $lexer->next();
        $returns = null;

        while (true) {

            switch ($prev->getType()) {

                case Token::T_EOF:
                    break 2;

                case Token::T_BOF:
                case Token::T_EOL:
                    $prev = self::expect($lexer->next(), [Token::T_BOL]);
                    break;

                case Token::T_BOL:
                    $prev = self::expect($lexer->next(), [Token::T_FUNCTION]);
                    break;

                case Token::T_FUNCTION:

                    $class = __NAMESPACE__."\\Functions\\" . $prev->getValue() . "Function";
                    if (!class_exists($class)) {
                        throw new \RuntimeException("Function " . $prev->getValue() . " does not exist at " . $class);
                    }
                    $fn = $container->make($class);

                    $args = [];

                    $prev = self::expect($lexer->next(), [
                        Token::T_FUNCTION_ARG_SEPARATOR,
                        Token::T_EOF,
                        Token::T_EOL
                    ]);

                    while ($prev->getType() === Token::T_FUNCTION_ARG_SEPARATOR) {

                        // Get the ARGUMENT
                        $prev = self::expect($lexer->next(), [
                            Token::T_STRING_LITERAL,
                            Token::T_CONSTANT,
                            Token::T_EXPRESSION,
                            Token::T_INLINE_EXPRESSION,
                        ]);

                        switch ($prev->getType()) {
                            case Token::T_STRING_LITERAL:
                                $args[] = $prev->getValue();
                                break;

                            case Token::T_CONSTANT:
                                if (!isset($scope->constants[$prev->getValue()])) {
                                    throw new \RuntimeException("Const " . $prev->getValue() . " is not defined");
                                }
                                $args[] = $scope->constants[$prev->getValue()];
                                break;
                            
                            case Token::T_EXPRESSION:
                                $args[] = $this->evaluateExpression($prev, $input, $output);
                                break;

                            case Token::T_INLINE_EXPRESSION:
                                $args[] = $prev;
                                break;

                            default:
                                throw new \RuntimeException("Unhandled token: " . $prev->getType());
                        }

                        $prev = self::expect($lexer->next(), [
                            Token::T_FUNCTION_ARG_SEPARATOR,
                            Token::T_EOF,
                            Token::T_EOL
                        ]);
                    }

                    $returns = call_user_func_array([$fn, '__invoke'], $args);
                    break;

                default:
                    throw new \RuntimeException("Unhandled token: " . $prev->getType());
            }
        }

        return $returns;
    }

    public static function expect(Token $token, array $tokens): Token
    {
        if (!in_array($token->getType(), $tokens)) {
            throw new \RuntimeException(
                "Unexpected " . $token->getType() . ". Expected one of: " . implode($tokens)
            );
        }

        return $token;
    }
}