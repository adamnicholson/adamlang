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
                return new Token(Token::T_FUNCTION, $this->readTil(" "));
                break;

            case Token::T_FUNCTION:
                return new Token(Token::T_FUNCTION_ARG_SEPARATOR, $this->readTil('"'));
                break;

            case Token::T_FUNCTION_ARG_SEPARATOR:
                $this->stream->read(); // "
                $token = new Token(Token::T_FUNCTION_ARG, $this->readTil('"'));
                $this->stream->read(); // "
                return $token;
                break;

            case Token::T_FUNCTION_ARG:
                return new Token(Token::T_EOL, $this->stream->read());
                break;

            default:
                throw new \RuntimeException("Unexpected " . $previous->getType());

        }
    }

    private function readTil(string $ends): string 
    {
        $value = "";

        while (($char = $this->stream->peek()) != $ends) {

            if ($this->stream->ended()) {
                throw new \RuntimeException("Unexpected end of stream after $value");
            }

            $value .= $this->stream->read();
        }

        return $value;
    }
}