<?php

namespace Adamnicholson\Adamlang\Functions;

class LoremFunction
{
    public function __invoke(): string
    {
        return "lorem ipsum";
    }
}