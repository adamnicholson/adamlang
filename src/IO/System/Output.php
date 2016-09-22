<?php

namespace Adamnicholson\Adamlang\IO\System;

use Adamnicholson\Adamlang\Output as OutputInterface;

class Output implements OutputInterface
{
    public function write(string $output)
    {
        echo $output;
    }
}