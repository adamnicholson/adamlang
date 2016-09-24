<?php

namespace Adamnicholson\Adamlang\Functions;

class StrFunction
{
    public function __invoke($arg): string
    {
        if (!is_int($arg) && !is_string($arg)) {
            throw new \RuntimeException("Only integers can be case to strings, given " . gettype($arg));
        }

        return (string) $arg;
    }
}