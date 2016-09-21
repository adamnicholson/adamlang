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
            case Token::TYPE_BOF:
                return new Token(Token::TYPE_FUNCTION, $this->readTil(" "));
                break;

            case Token::TYPE_FUNCTION:
                return new Token(Token::TYPE_FUNCTION_ARG_SEPARATOR, $this->readTil('"'));
                break;

            case Token::TYPE_FUNCTION_ARG_SEPARATOR:
                $this->stream->read(); // "
                $token = new Token(Token::TYPE_STRING_LITERAL, $this->readTil('"'));
                $this->stream->read(); // "
                return $token;
                break;

            default:
                throw new \RuntimeException("Unexpected token");

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