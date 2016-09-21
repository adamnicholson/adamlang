<?php

namespace Adamnicholson\Adamlang\Functions;

use Adamnicholson\Adamlang\Interpreter;
use Adamnicholson\Adamlang\Output;
use Adamnicholson\Adamlang\Stream;
use Adamnicholson\Adamlang\Token;
use Adamnicholson\Adamlang\Tokenizer;

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
     * @var Tokenizer
     */
    private $tokenizer;

    /**
     * PrintFunction constructor.
     * @param Stream $stream
     * @param Output $output
     * @param Tokenizer $tokenizer
     */
    public function __construct(Stream $stream, Output $output, Tokenizer $tokenizer)
    {
        $this->stream = $stream;
        $this->output = $output;
        $this->tokenizer = $tokenizer;
    }

    public function __invoke(Token $token)
    {
        $space = $this->tokenizer->next($token); // assert space?
        $string = $this->tokenizer->next($space); // assert string?
        $this->output->write(strtoupper($string->getValue()));
        return $token;
    }
}