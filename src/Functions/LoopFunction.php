<?php

namespace Adamnicholson\Adamlang\Functions;

class LoopFunction
{
    public function __invoke(int $repeat, callable $callback)
    {
        for ($i=1; $i<=$repeat; $i++) {
            $callback();
        }
    }
}