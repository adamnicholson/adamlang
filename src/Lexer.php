<?php

namespace Adamnicholson\Adamlang;

use Adamnicholson\Adamlang\IO\InMemoryIO;

class Lexer
{
    /**
     * @var Stream
     */
    private $stream;

    /**
     * @var Token
     */
    private $previous;

    /**
     * Tokenizer constructor.
     * @param Stream $stream
     */
    public function __construct(Stream $stream)
    {
        $this->stream = $stream;
        $this->previous = new Token(Token::T_BOF);
    }

    public function getStream()
    {
        return $this->stream;
    }

    public function next(): Token
    {
        $this->previous = $this->getNext();
        return $this->previous;
    }

    private function readTil(string $ends): string
    {
        $value = "";
        while (($char = $this->stream->peek()) != $ends) {
            $value .= $this->stream->read();
        }
        return $value;
    }

    /**
     * @return string
     */
    private function readTilLayerEnds($open, $close)
    {
        $value = "";
        $layers = 0;
        while (true) {
            if ($this->stream->peek() === $open) {
                $layers++;
            }
            if ($this->stream->peek() === $close) {
                if ($layers === 0) {
                    break;
                }
                $layers--;
            }

            $value .= $this->stream->read();
        }
        return $value;
    }

    private function readTilPatternOrEof($pattern)
    {
        $value = "";
        try {
            while (!preg_match($pattern, ($char = $this->stream->peek()))) {
                $value .= $this->stream->read();
            }
        } catch (\OutOfBoundsException $e) {
            // EOF
        }

        return $value;
    }

    /**
     * @return Token
     */
    private function getNext()
    {
        switch ($this->previous->getType()) {

            case Token::T_BOF:
            case Token::T_EOL:
                return new Token(Token::T_BOL);

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

                if ($this->stream->peek() === ':') {
                    $this->stream->read(); // "
                    $token = new Token(Token::T_VALUE_REFERENCE, $this->readTilPatternOrEof('/[\s\n]/'));
                    return $token;
                }

                if ($this->stream->peek() === '{') {
                    $this->stream->read(); // (
                    $value = $this->readTilLayerEnds('{', '}');
                    $token = new Token(Token::T_INLINE_EXPRESSION, new Lexer(new InMemoryIO($value)));
                    $this->stream->read(); // )
                    return $token;
                }

                if ($this->stream->peek() === '(') {
                    $this->stream->read(); // (
                    $value = $this->readTilLayerEnds('(', ')');
                    $token = new Token(Token::T_EXPRESSION, new Lexer(new InMemoryIO($value)));
                    $this->stream->read(); // )
                    return $token;
                }

                return new Token(Token::T_CONSTANT, $this->readTilPatternOrEof('/[\s\n]+/'));
                break;

            case Token::T_FUNCTION_ARG:
                return new Token(Token::T_EOL, $this->stream->read());
                break;

            case Token::T_EXPRESSION:
            case Token::T_CONSTANT:
            case Token::T_INLINE_EXPRESSION:
            case Token::T_VALUE_REFERENCE:
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
                throw new \RuntimeException("Nothing can follow a " . $this->previous->getType());

        }
    }
}