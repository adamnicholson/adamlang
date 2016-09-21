<?php

namespace Adamnicholson\Adamlang;

class Tokenizer
{
    /**
     * @var Stream
     */
    private $stream;

    /**
     * Tokenizer constructor.
     * @param Stream $stream
     */
    public function __construct(Stream $stream)
    {
        $this->stream = $stream;
    }

    public function next(Token $previous): Token
    {
        switch ($previous->getType()) {
            case Token::T_BOF:
            case Token::T_BOL:
                $value = "";
                while (true) {
                    if ($this->stream->ended() || $this->stream->peek() === " ") {
                        break;
                    }
                    $value .= $this->stream->read();
                }
                return new Token(Token::T_FUNCTION, $value);

            case Token::T_FUNCTION:

                if ($this->stream->ended()) {
                    return new Token(Token::T_EOF);
                }

                if ($this->stream->peek() === " ") {
                    return new Token(Token::T_FUNCTION_ARG_SEPARATOR, $this->stream->read());
                }

                throw new \RuntimeException("Expected EOF or ARG_SEPARATOR");

            case Token::T_FUNCTION_ARG_SEPARATOR:
                if ($this->stream->peek() === '"') {
                    $this->stream->read(); // "
                    $token = new Token(Token::T_STRING_LITERAL, $this->readTil('"'));
                    $this->stream->read(); // "
                    return $token;
                }

                if ($this->stream->peek() === '(') {

                    $this->stream->read(); // (

                    $value = "";
                    $layers = 0;
                    while (true) {
                        if ($this->stream->peek() === '(') {
                            $layers++;
                        }
                        if ($this->stream->peek() === ')') {
                            if ($layers === 0) {
                                break;
                            }
                            $layers--;
                        }

                        $value .= $this->stream->read();
                    }

                    $token = new Token(Token::T_EXPRESSION, $value);
                    $this->stream->read(); // )
                    return $token;
                }

                throw new \RuntimeException("Unexpected " . $this->stream->peek() . ", expecting \" or (");
                break;

            case Token::T_FUNCTION_ARG:
                return new Token(Token::T_EOL, $this->stream->read());
                break;

            case Token::T_EXPRESSION:
            case Token::T_STRING_LITERAL:
            case Token::T_FUNCTION_ARG:
                if ($this->stream->ended()) {
                    return new Token(Token::T_EOF);
                }

                $nextChar = $this->stream->peek();

                if ($nextChar === "\n") {
                    return new Token(Token::T_EOL, $this->stream->read());
                } elseif ($nextChar === " ") {
                    return new Token(Token::T_FUNCTION_ARG_SEPARATOR, $this->stream->read());
                } else {
                    throw new \RuntimeException("Expecting EOL or ARG_SEPARATOR, got " . ord($nextChar));
                }

            default:
                throw new \RuntimeException("Unexpected " . $previous->getType());

        }
    }

    private function readTil(string $ends): string 
    {
        $value = "";
        while (($char = $this->stream->peek()) != $ends) {
            $value .= $this->stream->read();
        }
        return $value;
    }
}