<?php

namespace Adamnicholson\Adamlang;

class ExecutableTest extends \PHPUnit_Framework_TestCase
{
    public function test_executes()
    {
        $output = shell_exec(__DIR__ . "/../bin/adam " . __DIR__ . "/../examples/loop.adam");
        $this->assertEquals("Test: 0\nTest: 1\nTest: 2\nTest: 3\nTest: 4\n", $output);
    }
}
