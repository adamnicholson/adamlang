<?php

namespace Adamnicholson\Adamlang\Functions;

class ConcatFunction
{
    public function __invoke(...$strings): string
    {
        return implode("", $strings);
    }
}