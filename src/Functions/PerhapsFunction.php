<?php

namespace Adamnicholson\Adamlang\Functions;

class PerhapsFunction
{
    /**
     * @param $expression
     * @param $true
     * @param $false
     */
    public function __invoke($expression, $true, $false)
    {
        return self::getValue($expression)
            ? self::getValue($true)
            : self::getValue($false);
    }


    private static function getValue($expression)
    {
        if (is_callable($expression)) {
            return $expression();
        }

        return $expression;
    }
}