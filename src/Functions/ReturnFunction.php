<?php

namespace Adamnicholson\Adamlang\Functions;

class ReturnFunction
{
    public function __invoke($value)
    {
        return $value;
    }
}