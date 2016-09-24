<?php

namespace Adamnicholson\Adamlang\Functions;

class EqualsFunction
{
    public function __invoke(...$args): bool
    {
        if (count($args) < 2) {
            throw new \RuntimeException("At least 2 arguments must be passed to equals");
        }

        return count(array_unique($args)) === 1;
    }
}