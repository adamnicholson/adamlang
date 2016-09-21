<?php

namespace Adamnicholson\Adamlang\Functions;

use Adamnicholson\Adamlang\Output;
use Adamnicholson\Adamlang\Stream;
use Adamnicholson\Adamlang\Token;

class ShoutFunction
{
    public static function expr(Stream $stream, Output $output, Token $token, $tokenizer)
    {
        $space = $tokenizer->next($token, $stream); // assert space?
        $string = $tokenizer->next($space, $stream); // assert string?
        $output->write(strtoupper($string->getValue()));
        return $token;
    }
}