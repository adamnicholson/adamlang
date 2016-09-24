<?php

namespace Adamnicholson\Adamlang\Functions;

class ModFunction
{
    public function __invoke($a, $b)
    {
        return $a % $b;
    }
}