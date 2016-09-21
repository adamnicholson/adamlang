<?php

namespace Adamnicholson\Adamlang\Functions;

use Adamnicholson\Adamlang\Interpreter;
use Adamnicholson\Adamlang\Output;
use Adamnicholson\Adamlang\Stream;
use Adamnicholson\Adamlang\Token;

class ShoutFunction
{
    /**
     * @var Stream
     */
    private $stream;
    /**
     * @var Output
     */
    private $output;
    /**
     * @var Interpreter
     */
    private $tokenizer;

    /**
     * PrintFunction constructor.
     * @param Stream $stream
     * @param Output $output
     * @param Interpreter $tokenizer
     */
    public function __construct(Stream $stream, Output $output, Interpreter $tokenizer)
    {
        $this->stream = $stream;
        $this->output = $output;
        $this->tokenizer = $tokenizer;
    }

    public function __invoke(Token $token)
    {
        $space = $this->tokenizer->next($token, $this->stream); // assert space?
        $string = $this->tokenizer->next($space, $this->stream); // assert string?
        $this->output->write(strtoupper($string->getValue()));
        return $token;
    }
}